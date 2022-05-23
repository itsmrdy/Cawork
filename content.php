<?php
  require_once 'core/init.php';

  if(isset($_POST['limit'])){
      $limit = $_POST['limit'];
      $selectAll = $db->query("SELECT * FROM service_db");
      $rows = mysqli_num_rows($selectAll);
?>
  <div class="card-body">
  <input type="text" id="allPosts" value="<?= $rows; ?>" hidden/>
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <?php
      $query = $db->query("SELECT * FROM service_db LIMIT $limit");
      while ($freelancer = mysqli_fetch_assoc($query)):
                    ?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="admin/dist/img/avatar2.png" alt="user image">
                        <span class="username">
                          <a href="#"><?= $freelancer['name']; ?> </a>
                          
                        </span>
                        <span class="description">Posted - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <?= $freelancer['skills']; ?></p>
                      <p>
                      ₱<?= $freelancer['rate']; ?> <?= $freelancer['day_week']; ?></p>
                      <p>
                      <?= $freelancer['description']; ?></p>
                      
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view<?= $freelancer['reg_id']; ?>">View profile</button>
                       
                      </p>
                      </div>
                      <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                   
                    </div>
                    <!-- /.post -->

                   
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.tab-pane -->

                
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
<?php }?>