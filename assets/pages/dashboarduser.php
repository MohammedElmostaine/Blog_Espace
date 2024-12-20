<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php"); 
    exit();
}

$user_id = $_SESSION['user'];

$sql = "SELECT bp.title, bp.content,  bp.created_at, u.username, t.name  AS tag_name, u.username 
        FROM blog_posts bp 
        LEFT JOIN tags t ON bp.tag_id = t.id 
        LEFT JOIN users u ON bp.user_id = u.id 
        WHERE bp.user_id = ?";

$stmt = $connection->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src = ".\js\script.js" defer></script>
    <title>Dashboard - My Blog</title>
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
        <a href="index.html" class="hover:text-gray-200">Home</a>
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






 <section class="w-full flex  mt-10">


        <div class="w-[20%] m-2  p-4 bg-[#C4B4A4] rounded shadow">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <p>Welcome, <?php 
            $user = $result->fetch_assoc();
            echo htmlspecialchars($user['username']) ; ?>!</p>

        </div>
        
        

    <div class="  w-[78%]  m-2  p-4 bg-[#7C6E5D ] rounded shadow">
        <h1 class="text-3xl font-bold mb-6">My Blog Posts</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded shadow">
                        
                        <h2 class="text-xl font-semibold mt-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p class="text-gray-600 text-sm">By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
                        <p class="mt-2"><?php echo htmlspecialchars($post['content']); ?></p>
                        <?php if ($post['tag_name']): ?>
                            <p class="text-gray-500 text-sm mt-2">Tag: <?php echo htmlspecialchars($post['tag_name']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No posts found. Please create a new post.</p>
        <?php endif; ?>

    </div>
    </section>
    

</body>
</html>

<?php

$stmt->close();
$connection->close();
?>