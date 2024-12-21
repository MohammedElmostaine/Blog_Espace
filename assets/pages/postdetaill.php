<?php
include 'config.php';

session_start();





// Get the post ID from the URL
$post_id = $_GET['id'];

// Fetch the post details from the database
$sql = "SELECT blog_posts.title, blog_posts.content, blog_posts.created_at, users.username 
        FROM blog_posts 
        JOIN users ON blog_posts.user_id = users.id 
        WHERE blog_posts.id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

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
        echo'<a href="dashboarduser.php" class="text-black hover:text-gray-200">Dashboard</a>
            <a href="addpost.php" class="hover:text-gray-200">Add Post</a>';
        
        }
        ?>
         
      </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden bg-[#CCCCC4] md:hidden ">
      <a href="index.html" class="block px-4 py-2 hover:bg-white hover:text-black">Home</a>
      <?php
        
        if (isset($_SESSION['user'])) {
        echo'<a href="dashboarduser.php" class="block px-4 py-2 hover:bg-white hover:text-black">Dashboard</a>
        <a href="addpost.php" class="hover:text-gray-200">Add Post</a>';
        
        }
        ?>
      
      <!-- <a href="login.html" class="block px-4 py-2 hover:bg-white hover:text-black">Login</a>
      <a href="register.html" class="block px-4 py-2 hover:bg-white hover:text-black">Register</a> -->
      <!-- <button id="toggle-form" class="toggle-form bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </button> -->
    </div>
  </nav>



    <!-- Main Content -->
    <div class="container mx-auto py-6">
        
        <div class="mt-6">
            

            <div class="mt-4">
                
                    <div class="bg-white shadow-md rounded p-4 mt-4">
                        <h3 class="text-xl font-bold"><?php echo $row['title']; ?></h3>
                        <?php
                        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                        ?>
                        <div class="flex justify-between items-center mt-4">
                            <div class="flex items-center">
                                <span><?php echo $row['created_at']; ?></span>
                            </div>
                </div>
            </div>
        
    </div>
</div>

</body>

</html>

