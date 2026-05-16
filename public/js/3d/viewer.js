import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OBJLoader } from 'three/addons/loaders/OBJLoader.js';

export function init3DViewer(containerId, modelUrl, fileType) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x1a1a2e);
    scene.fog = new THREE.FogExp2(0x1a1a2e, 0.02);

    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(5, 5, 10);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.autoRotate = false;
    controls.enableZoom = true;
    controls.enablePan = true;
    controls.zoomSpeed = 1.2;
    controls.rotateSpeed = 1.0;

    const ambientLight = new THREE.AmbientLight(0x404060);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 10, 7);
    directionalLight.castShadow = true;
    scene.add(directionalLight);

    const fillLight = new THREE.PointLight(0x4466cc, 0.3);
    fillLight.position.set(0, -5, 0);
    scene.add(fillLight);

    const backLight = new THREE.PointLight(0xffaa66, 0.5);
    backLight.position.set(-3, 2, -5);
    scene.add(backLight);

    const gridHelper = new THREE.GridHelper(20, 20, 0x888888, 0x444444);
    gridHelper.position.y = -2;
    scene.add(gridHelper);

    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'absolute inset-0 flex items-center justify-center bg-black/50 rounded-xl';
    loadingDiv.innerHTML = '<div class="text-white text-center"><div class="loading-spinner mx-auto mb-2"></div><p>Loading 3D model...</p></div>';
    loadingDiv.style.position = 'absolute';
    loadingDiv.style.top = '0';
    loadingDiv.style.left = '0';
    loadingDiv.style.right = '0';
    loadingDiv.style.bottom = '0';
    loadingDiv.style.display = 'flex';
    loadingDiv.style.alignItems = 'center';
    loadingDiv.style.justifyContent = 'center';
    loadingDiv.style.backgroundColor = 'rgba(0,0,0,0.5)';
    loadingDiv.style.borderRadius = '12px';
    loadingDiv.style.zIndex = '10';
    container.style.position = 'relative';
    container.appendChild(loadingDiv);

    let loader;
    if (fileType === 'glb' || fileType === 'gltf') {
        loader = new GLTFLoader();
    } else if (fileType === 'obj') {
        loader = new OBJLoader();
    } else {
        loadingDiv.innerHTML = '<div class="text-red-500 text-center">Unsupported file type</div>';
        return;
    }

    loader.load(modelUrl,
        (object) => {
            loadingDiv.remove();

            let model = object.scene || object;

            model.traverse((child) => {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                }
            });

            scene.add(model);

            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            const size = box.getSize(new THREE.Vector3());

            model.position.x -= center.x;
            model.position.z -= center.z;

            const maxDim = Math.max(size.x, size.y, size.z);
            const scale = 3 / maxDim;
            model.scale.set(scale, scale, scale);

            controls.target.set(0, 0, 0);
            controls.update();
        },
        (xhr) => {
            const percent = Math.round((xhr.loaded / xhr.total) * 100);
            loadingDiv.innerHTML = `<div class="text-white text-center"><div class="loading-spinner mx-auto mb-2"></div><p>Loading 3D model... ${percent}%</p></div>`;
        },
        (error) => {
            console.error('Error loading model:', error);
            loadingDiv.innerHTML = '<div class="text-red-500 text-center">Failed to load 3D model</div>';
        }
    );

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
}