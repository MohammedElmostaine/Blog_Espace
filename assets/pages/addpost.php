<?php

include 'config.php';


session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


$tags = [];
$sql = "SELECT id, name FROM tags";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $tags[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $tag_id = intval($_POST['tag_id']);
    $user = $_SESSION['user'];


    $sql = "INSERT INTO blog_posts (user_id, title, content, tag_id) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("issi", $user, $title, $content,  $tag_id);

    if ($stmt->execute()) {
        echo "<script>alert('Post added successfully!'); window.location.href='dashboarduser.php';</script>";
    } else {
        echo "<script>alert('Error adding post. Please try again.');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src = ".\js\script.js" defer></script>
    <title>Add New Post</title>
  <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
  <nav class="bg-[#CCCCC4] text-white">
    <div class="container mx-auto flex justify-between items-center py-4 px-4">
      <!-- Logo -->
      <a href="index.html" class="text-2xl font-bold">Blog Espace</a>
      
      <!-- Burger Menu (Hidden on large screens) -->
      <button id="menu-btn" class="block md:hidden focus:outline-none">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      
      <!-- Links (Hidden on small screens) -->
      <div id="menu" class="hidden md:flex space-x-6 flex items-center">
        <a href="../../index.html" class="hover:text-gray-200">Home</a>
        <?php
        
        if (isset($_SESSION['user'])) {
        echo'<a href="dashboarduser.php" class="text-black hover:text-gray-200">Dashboard</a>';
        
        }
        ?>
         <a href="addpost.php" class="hover:text-gray-200">Add Post</a>
      </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden bg-[#CCCCC4] md:hidden ">
      <a href="index.html" class="block px-4 py-2 hover:bg-white hover:text-black">Home</a>
      <?php
        
        if (isset($_SESSION['user'])) {
        echo'<a href="dashboarduser.php" class="block px-4 py-2 hover:bg-white hover:text-black">Dashboard</a>';
        
        }
        ?>
      
      <!-- <a href="login.html" class="block px-4 py-2 hover:bg-white hover:text-black">Login</a>
      <a href="register.html" class="block px-4 py-2 hover:bg-white hover:text-black">Register</a> -->
      <!-- <button id="toggle-form" class="toggle-form bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </button> -->
    </div>
  </nav>

    <div class="w-[80%] justify-self-center mt-10">
        <h1 class="text-3xl font-bold mb-6">Add New Post</h1>

        <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title :</label>
                <input type="text" id="title" name="title" required class="h-[30px] mt-1 block w-full border-black rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-black">
            </div>
            <div class="mb-4">
                <label for="content" class="block  text-gray-700">Content :</label>
                <textarea id="content" name="content" required class="mt-1 block w-full border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-black" rows="5"></textarea>
            </div>
            <div class="mb-4">
                <label for="tag_id" class=" block text-gray-700">Tag :</label>
                <select id="tag_id" name="tag_id" required class="h-[30px] mt-1 block w-full border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-black">
                    <option value="">Select a tag</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo $tag['id']; ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-[#CCCCC4] text-white hover:bg-[#594A3C] py-2 rounded">Add Post</button>
        </form>
    </div>

</body>
</html>

<?php
$connection->close();
?>