<!-- ok -->

<!-- search name -->
<form action="blog.php" method="get" class="search-form">
    <input type="text" name="search" class="form-control" autocomplete="off" placeholder="search name here">
    <button type="submit" class="btn btn-outline-success" style="width:100%;font-size:13px;color: rgb(156, 255, 212);">S E A R C H</button>
</form>



<hr style="width:100%;">
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card" style="border: none">
            <?php
            foreach ($post_resutl as $pr) {
                $img = $pr['img'];
                $created_at = $pr['created_at'];
                $id = $pr['blog_id'];
                $title = $pr['title'];
            ?>
                <div class="row">
                    <div class="col-lg-4">
                        <a href="blog-detail.php?blog_id=<?php echo $id ?>">
                            <img src="<?php echo $img ?>" style="width:100px;height:100px;" alt="">
                        </a>
                        <!-- <img src="img/download.jpg" style="width:100px;height:100px;" alt=""> -->
                    </div>
                    <div class="col-lg-8">
                        <div class="card-body">
                            <div class="review-header">
                                <strong><a href="blog-detail.php?blog_id=<?php echo $id ?>"><?php echo $title ?></a></strong>
                            </div>
                            <p><?php echo $created_at ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <br><br>
        <div>
            <h2>Tag</h2>
            <div class="row">
                <?php
                $query3 = "SELECT DISTINCT blog_category_id FROM blog ORDER BY RAND() LIMIT 4";
                $result3 = executeResult($query3);
                foreach ($result3 as $r) {
                    $tag = executeSingleResult("SELECT * FROM blog_category WHERE blog_category_id = {$r['blog_category_id']}")['name'];
                    // $tag = $r['blog_category_id'];
                ?>
                    <div class="col-lg-6">
                        <a href="blog-detail.php?blog_id=<?php echo $id ?>">
                            <button class="button-81" role="button" style="float:left;">
                                <span style="font-size: 15px;"><?php echo $tag ?></span>
                            </button>
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- ok end -->