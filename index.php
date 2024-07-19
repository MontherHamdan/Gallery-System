<?php
include("includes/header.php");

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 4;

$items_total_count = Photo::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= "LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";
$photo = Photo::find_this_query($sql);

?>


<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thumbnail row">

            <?php foreach ($photo as $photos) : ?>
                <div class="col-xs-6 col-md-3">

                    <a class="thumbnail" href="photo_comments_main.php?id=<?php echo $photos->id; ?>">

                        <img class="home_page_photo" src="admin/<?php echo $photos->picture_path(); ?>" alt="">
                    </a>

                </div>
            <?php endforeach; ?>

            <!-- pagination -->
        </div>
        <div class="row">
            <ul class="pagination">
                <?php
                if ($paginate->total_pages() > 1) {

                    //previous page
                    if ($paginate->has_previous()) {
                        echo "<li class='page-item'>
                        <a class='page-link' href='index.php?page={$paginate->previous()}'>Previous</a>
                        </li> ";
                    } else {
                        echo "<li class='page-item disabled'>
                        <a class='page-link' >Previous</a>
                        </li> ";
                    }

                    //links number
                    for ($i = 1; $i <= $paginate->total_pages(); $i++) {
                        if ($i == $paginate->current_page) {
                            echo "<li class='page-item active'>
                            <a class='page-link' href='index.php?page={$i}'>{$i}</a>
                            </li>";
                        } else {
                            echo "<li class='page-item'>
                            <a class='page-link' href='index.php?page={$i}'>{$i}</a>
                            </li>";
                        }
                    }

                    //next page
                    if ($paginate->has_next()) {
                        echo "<li class='page-item'>
                        <a class='page-link' href='index.php?page={$paginate->next()}'>Next</a>
                        </li> ";
                    } else {
                        echo "<li class='page-item disabled'>
                        <a class='page-link' >Next</a>
                        </li> ";
                    }
                }
                ?>

            </ul>
        </div>
    </div>




    <!-- Blog Sidebar Widgets Column
            <div class="col-md-4">
                 <?php
                    //   include("includes/sidebar.php");
                    ?>
            </div> -->

    <!-- /.row -->
</div>
<?php include("includes/footer.php"); ?>