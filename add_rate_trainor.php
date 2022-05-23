<?php
    require_once 'core/init.php';
    $training_id = $_GET['training_id'];
    $trainor_id = $_GET['trainor_id'];
    $my_id = $_GET['my_id'];
    if (empty($training_id) || empty($trainor_id) || empty($my_id)) {
?>
<script>
    history.back();
</script>
<?php
    }

    $user_validation = $db->query("SELECT id fROM reg_db WHERE id = '$trainor_id';");
    $user_validation_count = mysqli_num_rows($user_validation);

    $user_validation2 = $db->query("SELECT id fROM reg_db WHERE id = '$my_id';");
    $user_validation_count2 = mysqli_num_rows($user_validation2);

    if ($user_validation_count < 1 || $user_validation_count2 < 1) {
?>
<script>
    history.back();
</script>
<?php
    }

    $result = $db->query("SELECT * FROM reg_db WHERE id = '$trainor_id';");
    $user_row = mysqli_fetch_assoc($result);

    $validate_rating = $db->query("SELECT id FROM trainor_ratings_db WHERE training_id = '$training_id' AND reg_id = '$my_id' AND trainor_id = '$trainor_id' AND delete_flg = '0';");
    $validate = mysqli_num_rows($validate_rating);

    if ($validate > 0) {
?>
<script>
    alert('You already add a rating for this Trainor');
    history.back();
</script>
<?php
    }
?>
<html>
<head>
    <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
</head>
<body>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
          <a href="#" class="navbar-brand">
            <span class="brand-text font-weight-bold text-success"
            style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Review</a>
              </li>
              <!-- <li class="nav-item">
                <a href="../client.php" class="nav-link text-secondary">Home</a>
              </li> -->
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-transparent"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
<div class="container">
        <div class="card mt-5">
            <div class="card-body p-5">
                <form method="post">
                    <div class="card p-3">
                        <h3>Rate and Review</h3>
                    </div>

                    <div>
                        <label class="h5 mt-5">Name</label>
                        <input class="form-control" type="text" name="name" value="<?=$user_row['firstname']?> <?=$user_row['middlename']?> <?=$user_row['lastname']?>" aria-label="Disabled input example" disabled readonly>
                    </div>

                    <div class="rateyo py-3" id= "rating"
                        data-rateyo-rating="0"
                        data-rateyo-num-stars="5"
                        data-rateyo-score="3">
                    </div>

                    <span class="result h5" id="rate_rating">Rating: 0</span>
                    <input type="hidden" name="rating">

                    </div>

                    <div class="container">
                        <label>Reviews</label>
                        <textarea class="form-control" id="review" type="text" cols="10" row="3" name="review" placeholder="Type here"></textarea>
                        <div class="py-3">
                            <button id="submit_btn" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container mb-5">
            <h3 class="text-bold mt-4">Reviews and ratings – guidelines, terms and conditions</h3>
            <div class="mt-3">
                The rater and reviewer can only select one rating that best describes the overall condition of the transaction. 
                Please properly point out the work outcome, communication, and overall satisfaction with your transactions to the other party
            </div>
            <div class="mt-3">
                 Consider this when you’re going to rate your transaction:
            </div>
            <div>
                <ul>
                    <li>1.	Whether the work was done completely as you expected.</li>
                    <li>2.	Whether the work discussed was done properly.</li>
                    <li>3.	Whether the agreed employment has been complied with.</li>
                    <li>4.	Is the work agreement and condition properly executed?</li>
                    <li>5.	Are you satisfied with the outcome of the transaction?</li>
                </ul>
            </div>
            <div class="mt-3">
                    Rating Consequences: Rating Consequences are automatic in the system. 
                    When the user reaches the 2.9 ratings his account will be 1 month suspended and if his rating reaches 2.0 it
                    will be a 2-month suspension and if the rating goes to 1.0 the account will be blocked.
            </div>
            <div class="mt-3">
                Note: please properly consider your rating in your transaction as mentioned above there is a 
                consequence when the rating reaches as low as 2.9 ratings and can also be blocked when it reaches a 1.0 rating. 
                As a user of the website, you have the obligation to rate honestly and considerably towards the other party you were put your rating
            </div>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>


    $(function () {
        $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('Rating : '+ rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });

</script>
</body>

</html>
<script>
    $('#submit_btn').click(function() {
        event.preventDefault();
        var rate_rating = $('#rate_rating').text();
        var review = $('#review').val();

        var reg_id = '<?=$my_id?>';

        var request = "rate_trainor";

        var trainor_id = '<?=$trainor_id?>';

        var training_id = '<?=$training_id?>';

        var error
        if (review === '') {
            error = 'Please write a review';
        }
        if (rate_rating === '0') {
            error = 'Please add a rating';
        }
        else{
            var rating_text = rate_rating.split(' ');
            var rating = rating_text[2];

            if (rating === 0) {
                error = 'Please add a rating';
            }
        }

        if (error === undefined) {
            var x = confirm('Please be sure that you completed this training before you rate and review');

            if (x) {
                $.ajax({
                    method: 'post',
                    url: 'ajax_request.php',
                    data: {
                        rating:rating,
                        review:review,
                        reg_id:reg_id,
                        request:request,
                        trainor_id:trainor_id,
                        training_id:training_id
                    },
                    success:function(data){
                        if (data === '1') {
                            alert('Rating successfully sent');
                        }
                        else{
                            alert('An error occured');
                        }
                        window.location = 'freelance.php';
                    }
                });
            }
        }
        else{
            alert(error);
        }
    });
</script>