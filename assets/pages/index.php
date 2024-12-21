<?php
session_start();


include 'config.php';

$sql = "SELECT bp.id, bp.title, bp.content,  bp.created_at, u.username, t.name  AS tag_name, u.username 
        FROM blog_posts bp 
        LEFT JOIN tags t ON bp.tag_id = t.id 
        LEFT JOIN users u ON bp.user_id = u.id";

$stmt = $connection->prepare($sql);

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
        <a href="index.html" class="text-black hover:text-gray-200">Home</a>
        <?php
        
        if (isset($_SESSION['user'])) {
        echo'<a href="dashboarduser.php" class=" hover:text-gray-200">Dashboard</a>
         <a href="addpost.php" class="hover:text-gray-200">Add Post</a>';
        
        }else{
          echo'<a href="../../index.php" class="bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </a>';
        }
        ?>
        
      </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden bg-[#CCCCC4] md:hidden ">
      <a href="index.html" class="block px-4 py-2 hover:bg-white hover:text-black">Home</a>
      <?php
        
        if (isset($_SESSION['user'])) {
        echo'<a href="dashboarduser.php" class="block px-4 py-2 hover:bg-white hover:text-black">Dashboard</a>';
        
        }else{
          echo'<a href="../../index.php" class="bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </a>';
        }
        ?>
      
      <!-- <a href="login.html" class="block px-4 py-2 hover:bg-white hover:text-black">Login</a>
      <a href="register.html" class="block px-4 py-2 hover:bg-white hover:text-black">Register</a> -->
      <!-- <button id="toggle-form" class="toggle-form bg-[#807F7B] text-white py-2 px-4 rounded hover:bg-[#FFFFED] mb-[5px] hover:text-black justify-selfe-center">
    Register/Connexion
  </button> -->
    </div>
  </nav>


<section class="flex">

<div class="m-[1%] w-[18%] mx-auto p-5 bg-white shadow-md border border-gray-200 rounded-lg">
  <h2 class="text-xl font-bold mb-4 text-gray-900">Filter by Tags</h2>
  <ul class="space-y-2">
    <li>
      <a href="index.php" class="text-[#CCCCC4] hover:underline">All Tags</a>
    </li>
    <?php
    $tag_sql = "SELECT id, name FROM tags";
    $tag_stmt = $connection->prepare($tag_sql);
    $tag_stmt->execute();
    $tag_result = $tag_stmt->get_result();

    while ($tag = $tag_result->fetch_assoc()): ?>
      <li>
        <a href="index.php?tag_id=<?php echo $tag['id']; ?>" class="text-[#CCCCC4] hover:underline">
          <?php echo htmlspecialchars($tag['name']); ?>
        </a>
      </li>
    <?php endwhile; ?>
  </ul>
</div>

<div class="w-[80%] p-5">

<?php
$tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : null;

if ($tag_id) {
  $sql .= " WHERE bp.tag_id = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("i", $tag_id);
} else {
  $stmt = $connection->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<?php if ($result->num_rows > 0): ?>
  <div class="w-[100%] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php while ($post = $result->fetch_assoc()): ?>
  <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm mb-5  flex flex-col justify-between">
    <div class="p-5">
    
      <a href="postdetaill.php?id=<?php echo $post['id']; ?>">
        <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2"><?php echo htmlspecialchars($post['title']); ?></h5>
      </a>
      <p class="text-gray-600 text-sm">By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
      <p class="font-normal text-gray-700 mb-3"><?php echo htmlspecialchars(explode("\n", $post['content'])[0]); ?></p>
      </div>
      <div class="flex justify-between items-center p-5">
      <p>Tag: <?php echo htmlspecialchars($post['tag_name']); ?></p>
      <a class="text-white bg-[#CCCCC4] hover:bg-[#CCCCC4] focus:ring-4 focus:ring-[#CCCCC4] font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center" href="postdetaill.php?id=<?php echo $post['id']; ?>">
        Read more
      </a>
      </div>
    
  
  
  </div>
  <?php endwhile; ?>
</div>
<?php else: ?>
      <p>No posts found. Please create a new post.</p>
<?php endif; ?>

        </section>



            
                
                  
        

</body>
</html>