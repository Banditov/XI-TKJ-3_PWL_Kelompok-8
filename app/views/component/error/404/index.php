<div class="error-page">
    <div class="error-container">
        <h1 class="error-code"><?= $error_code ?? '404' ?></h1>
        <h2 class="error-title"><?= $error_message ?? 'Page Not Found' ?></h2>
        <p class="error-message"><?= $error_description ?? 'The page you are looking for does not exist.' ?></p>
        <a href="/" class="home-button">Return to Homepage</a>
    </div>
</div>

<style>
.error-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.error-container {
    text-align: center;
    padding: 40px;
    max-width: 600px;
    margin: 0 auto;
}

.error-code {
    font-size: 120px;
    font-weight: bold;
    color: #e74c3c;
    margin: 0;
    line-height: 1;
}

.error-title {
    font-size: 32px;
    color: #2c3e50;
    margin: 20px 0;
}

.error-message {
    font-size: 18px;
    color: #7f8c8d;
    margin: 20px 0 30px;
}

.home-button {
    display: inline-block;
    padding: 12px 30px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.home-button:hover {
    background-color: #2980b9;
}
</style>