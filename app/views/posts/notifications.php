<Title>Notifications | ImmaSpark</Title>
<link rel="stylesheet" href="/css/responsive/notifications.css">

    <?php

    $notifications = [
        ["name" => "CHRISTOPHER", "message" => "Give you a feedback", "date" => "13/06/2026"],
        ["name" => "CHRISTOPHER", "message" => "Give you a feedback", "date" => "13/06/2026"],
        ["name" => "CHRISTOPHER", "message" => "Give you a feedback", "date" => "13/06/2026"],
        ["name" => "CHRISTOPHER", "message" => "Give you a feedback", "date" => "13/06/2026"],
    ];
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Notifications</title>
    <body>

        <div class="container">

            <!-- Sidebar -->
            <div class="sidebar">
                <h2>Imma Spark</h2>
                <div class="menu">
                    <a href="#">Explore</a>
                    <a href="#">Latest</a>
                    <a href="#">Pinned</a>
                    <a href="#">Popular</a>
                    <a href="#">Create a Post</a>
                    <a href="#">Your Posts</a>
                    <a href="#" class="active">Notifications</a>
                    <a href="#">Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main">
                <input type="text" class="search-box" placeholder="Enter search terms">

                <div class="card">
                    <?php foreach ($notifications as $notif): ?>
                        <div class="notif">
                            <div class="notif-left">
                                <div class="avatar"></div>
                                <div class="notif-text">
                                    <b><?php echo $notif['name']; ?></b> <?php echo $notif['message']; ?>
                                    <small>Lorem ipsum dolor sit amet</small>
                                </div>
                            </div>

                            <div class="notif-right">
                                <div><?php echo $notif['date']; ?></div>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>

    </body>

    </html>