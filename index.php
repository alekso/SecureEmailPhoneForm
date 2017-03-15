<!DOCTYPE html>
<html lang="">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="jumbotron vertical-center">
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption">
                    <h4>Option 1. Add your phone number</h4>
                    <form id="add_form" name="add" action="src/server.php" method="POST">
                        <div class="form-group">
                            <label for="exampleInputPhone">Enter your PHONE</label>
                            <input type="phone" name="phone" class="form-control" id="exampleInputPhone" placeholder="Phone">
                            <?php if(isset($_COOKIE["phone"])) : ?>
                                <span id="helpBlock2" class="help-block"><?php echo $_COOKIE["phone"];?> </span>
                            <?php endif; ?>
                        </div>
                        <div class='form-group <?php echo (isset($_COOKIE["email"]))?"has-warning" : ""; ?>' >
                            <label for="exampleInputEmail">Enter your e-mail *</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                            <?php if(isset($_COOKIE["email"])) : ?>
                                <span id="helpBlock2" class="help-block"><?php echo $_COOKIE["email"];?> </span>
                            <?php endif; ?>
                        </div>
                        <p>You will be able to retrieve your phone number later on using your e-mail.</p>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption">
                    <h4>Option 2. Retrieve your phone number</h4>
                    <form id="retrieve_form" name="retrieve" action="src/server.php" method="POST">
                        <div class='form-group <?php echo (isset($_COOKIE["retrieve_email"]))?"has-warning" : ""; ?>'>
                            <label for="exampleInputEmail">Enter your e-mail *</label>
                            <input type="email" name="retrieve_email" class="form-control" id="exampleInputEmail" placeholder="Email">
                            <?php if(isset($_COOKIE["retrieve_email"])) : ?>
                                <span id="helpBlock2" class="help-block"><?php echo $_COOKIE["retrieve_email"];?></span>
                            <?php endif; ?>
                        </div>
                        <p>The phone number will be e-mailed to you.</p>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> <!-- /container -->
</div>
</body>
</html>
