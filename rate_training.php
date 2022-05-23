<?php
    require_once 'core/init.php';
    $reg_id = $_GET['worker'];
    $service_id = $_GET['service'];
    $my_id = $_GET['from'];
    if (empty($reg_id) || empty($service_id) || empty($my_id)) {
?>
<script>
    history.back();
</script>
<?php
    }
    $result = $db->query("SELECT * FROM reg_db WHERE id = '$reg_id';");
    $user_row = mysqli_fetch_assoc($result);

    $validate_rating = $db->query("SELECT id FROM reviews_db WHERE service_id = '$service_id' AND from_id = '$my_id' AND delete_flg = '0';");
    $validate = mysqli_num_rows($validate_rating);

    if ($validate > 0) {
?>
<script>
    alert('You already add a rating for this Skilled Worker');
    window.location = 'client.php';
</script>
<?php
    }
?>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
</head>
<body>
<div class="container">
    <div class="row">
    <style>h3 {
                   word-spacing: 0px;
                   font-family: "Times New Roman", Times, serif;
                          }
                          .p1 {
                    font-family: "Times New Roman", Times, serif;
                          }
                         
                        
                      </style>
<form action="add_rate.php" method="post">

    <div>
        <h3>Rate and Review your Skilled Worker</h3>
    </div>

    <div>
         <label>Name</label>
        <input class="form-control" type="text" name="name" value="<?=$user_row['firstname']?> <?=$user_row['middlename']?> <?=$user_row['lastname']?>" aria-label="Disabled input example" disabled readonly>
    </div>

         <div class="rateyo" id= "rating"
         data-rateyo-rating="0"
         data-rateyo-num-stars="5"
         data-rateyo-score="3">
         </div>

    <span class='result' id="rate_rating">0</span>
    <input type="hidden" name="rating">

    </div>

    <div>
         <label>Reviews</label>
         <textarea class="form-control" id="review" type="text" cols="10" row="3" name="review" placeholder="Type here"></textarea>
    </div>
    <br>
    <div><input type="submit" id="submit_btn" name="add" class="btn btn-primary"> </div>

</form>
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
<?php
require_once 'core/init.php';
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = $_POST["name"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];

    $sql = "INSERT INTO ratings (name,rating,review) VALUES ('$name','$rating','$review')";
    if (mysqli_query($db, $sql))
    {
        echo "New Rate addedddd successfully";
    }
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
}
?>
<script>
    $('#submit_btn').click(function() {
        event.preventDefault();
        var rate_rating = $('#rate_rating').text();
        var review = $('#review').val();

        var reg_id = '<?=$reg_id?>';

        var request = "rate";

        var from_id = '<?=$my_id?>';

        var service_id = '<?=$service_id?>';

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
            $.ajax({
                method: 'post',
                url: 'ajax_request.php',
                data: {
                    rating:rating,
                    review:review,
                    reg_id:reg_id,
                    request:request,
                    from_id:from_id,
                    service_id:service_id
                },
                success:function(data){
                    if (data === '1') {
                        alert('Rating successfully sent');
                    }
                    else{
                        alert(data);
                    }
                    window.location = 'client.php';
                }
            });
        }
        else{
            alert(error);
        }
    });
</script>