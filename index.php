<?php
include_once 'db.php';
//$db->clearDb();
//foreach(range(0, 8) as $i)
    //$db->insertPost('title' . $i, 'body' . $i);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php-stuff</title>
</head>
<body>
    <header>
        <h1><a href="index.php">CSS is for losers</a></h1>
        <small><a href="register.php">Register</a></small>
        <small><a href="login.php">Login</a></small>
        <hr>
    </header>
    <form action="post.php" method="post">
        <input type="text" name="title" id="title" placeholder="Title"><br>
        <textarea name="body" id="body" cols="30" rows="10"></textarea><br>
        <br>
        <button type="submit">Create post</button>
    </form>

    <?php foreach (array_reverse($db->getPosts()) as $row): ?>
        <article id=<?= $row['id'] ?>>
        <h3>
            <?= $row['title'] ?>
            (<span><?= $row['points'] ?></span>)
        </h3>
        <button>+1</button>
        <button>-1</button>
            <p><?= $row['body'] ?></p>
        </article>
        <hr>
    <?php endforeach; ?>
</body>

<script>

for (const art of document.querySelectorAll('article')) {
    const id = art.id;
    const up = art.children[1];
    const down = art.children[2];
    up.addEventListener('click', (ev) => {
        vote(id, 1);
    });
    down.addEventListener('click', (ev) => {
        vote(id, -1);
    });
}

function vote(id, amm) {
    const xhr = new XMLHttpRequest();
    const fd = new FormData();
    fd.append('id', id);
    fd.append('amm', amm);
    xhr.open('post', 'vote.php');
    xhr.send(fd);
    let ptsEl = document.getElementById(id).children[0].children[0];
    let pts = parseInt(ptsEl.innerHTML);
    ptsEl.innerHTML = pts + amm;
}

</script>

</html>
