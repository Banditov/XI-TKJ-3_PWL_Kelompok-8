import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OBJLoader } from 'three/addons/loaders/OBJLoader.js';

export function init3DViewerInContainer(container, modelUrl, fileType, onLoaded) {
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
    container.style.position = 'relative';
    container.style.height = '300px';

    container.onclick = null;

    const width = container.clientWidth;
    const height = container.clientHeight;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x1a1a2e);

    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
    camera.position.set(5, 5, 10);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(window.devicePixelRatio);
    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.enableZoom = true;
    controls.enablePan = true;

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

    let loader;
    if (fileType === 'glb' || fileType === 'gltf') {
        loader = new GLTFLoader();
    } else if (fileType === 'obj') {
        loader = new OBJLoader();
    } else {
        container.innerHTML = '<div class="flex items-center justify-center h-full text-red-400">Unsupported file type: ' + fileType + '</div>';
        if (onLoaded) onLoaded();
        return;
    }

    loader.load(modelUrl,
        (object) => {
            console.log('Model loaded successfully');
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
            if (maxDim > 0) {
                const scaleAmount = 3 / maxDim;
                model.scale.set(scaleAmount, scaleAmount, scaleAmount);
            }

            controls.target.set(0, 0, 0);
            controls.update();

            if (onLoaded) onLoaded();
        },
        (xhr) => {
            // console.log(Math.round(xhr.loaded / xhr.total * 100) + '% loaded');
        },
        (error) => {
            console.error('Error loading model:', error);
            container.innerHTML = '<div class="flex items-center justify-center h-full text-red-400">Failed to load 3D model: ' + (error.message || 'Unknown error') + '</div>';
            if (onLoaded) onLoaded();
        }
    );

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    const resizeObserver = new ResizeObserver(() => {
        const newWidth = container.clientWidth;
        const newHeight = container.clientHeight;
        if (newWidth > 0 && newHeight > 0) {
            camera.aspect = newWidth / newHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(newWidth, newHeight);
        }
    });
    resizeObserver.observe(container);
}

export default { init3DViewerInContainer };