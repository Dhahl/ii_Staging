<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>*** DEV *** Irish Interest</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
       <div>
            <table>
                <thead>
                    <tr>
                        <th class="col-md-4"><?php $this->language->translate('ID'); ?></th>
                        <th class="col-md-4"><?php $this->language->translate('NAME'); ?></th>
                        <th class="col-md-4"><?php $this->language->translate('SURNAME'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user){ ?>
                    <tr>
                        <td class="col-md-4"><?php echo $user->id; ?></td>
                        <td class="col-md-4"><?php echo $user->login; ?></td>
                        <td class="col-md-4"><?php echo $user->real_name; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <h1>Hello, world!</h1>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>