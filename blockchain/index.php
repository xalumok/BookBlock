<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
<title>Books</title>
<style>
    body
    {
        text-align: center;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
    td {
        padding-bottom: 2px;
        padding-top: 2px;
        border: solid 1px black;
    }
</style>
<script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"
        type="application/javascript"></script>
</head>
<body>

<?php
    echo "Balance: ";
    require "getBalance.php";
    echo getBalance("0x3c77913ef287c6d16765b1b7308e8d5237851937");
?>
<h1>Books</h1>
<table align="center" bordercolor="black">
    <tbody>
        <tr>
            <th style="width: 20em;">Cover</th>
            <th style="width: 20em;" class="top">Title</th>
            <th style="width: 20em;" class="top">Rating</th>
        </tr>
        <tr>
            <td><img src="https://m.media-amazon.com/images/I/61uRpcdPhNL._AC_UY218_.jpg"></td>
            <td><a href="book.html">Introduction to Algorithms, 3rd Edition (The MIT Press)</a></td>
            <td>4.5</td>
        </tr>
        <tr>
            <td><img src="https://m.media-amazon.com/images/I/61uRpcdPhNL._AC_UY218_.jpg"></td>
            <td><a href="book.html">Introduction to Algorithms, 3rd Edition (The MIT Press)</a></td>
            <td>4.5</td>
        </tr>
        <tr>
            <td><img src="https://m.media-amazon.com/images/I/61uRpcdPhNL._AC_UY218_.jpg"></td>
            <td><a href="book.html">Introduction to Algorithms, 3rd Edition (The MIT Press)</a></td>
            <td>4.5</td>
        </tr>
    </tbody>
</table>
</body>
</html>
