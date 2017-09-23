<?php
require_once "script/items.php" ;

$errorMsg = "";

if (isset($_GET['item']) && !empty($_GET['item']) )
  list($items, $totalItems) = searchItem($_GET['item']) ;
else
  list ($items,$totalItems) = getItems();

if (empty($totalItems)){
  $errorMsg = "Items not found" ;
}
elseif (!empty($_GET['returnMsg'])) {
  $errorMsg = $_GET['returnMsg'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <title>Add Items</title>
</head>
<body>

<div class="container" style="margin-top: 3%;">

    <div class="col-md-4 col-md-offset-4">     
      <div class="row">
        <div id="logo" class="text-center">
        </div>
      <!-- Form is handle by auto_suggestion file  -->
      <form role="form" id="form-buscar" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
        <div class="form-group">
          <div class="input-group">
              <input id="search" class="form-control" type="text" name="item" placeholder="Title" required autofocus/>
              <span class="input-group-btn">
                <button name="search" class="btn btn-success" type="submit">
                  <i class="glyphicon glyphicon-search" aria-hidden="true"></i> Search
                </button>
              </span>
          </div>
        </div>
      </form>
      </div>            
    </div>
</div>

<div class="container">
  <div class="row">  
    <h1 class="text-center">Items Table</h1>

    <p class="text-center error">
      <?php echo $errorMsg ?>
    </p>
    
    <div class="col-md-10 col-md-offset-1">

      <div class="panel panel-default panel-table">
        <div class="panel-heading">
          <div class="row">
            <div class="col col-xs-6">
              <h3 class="panel-title">Items</h3>
            </div>
            <div class="col col-xs-6 text-right">
              <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#myModal">Add New</button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-list">
            <thead>
              <tr>
                <th class="text-center">Item-ID</th>
                <th class="text-center">Title</th>
                <th class="text-center">Price</th>
                <th class="text-center"><em class="fa fa-print"></em></th>
                <th class="text-center"><em class="fa fa-cog"></em></th>
              </tr> 
            </thead>
            <tbody>
              <?php for ($i=0; $i < count($items); $i++) { ?>
              <tr>
                <td class="text-center"><?php echo $items[$i]['item_id'] ?></td>
                <td><?php echo $items[$i]['title'] ?></td>
                <td class="text-center">Rs: <?php echo $items[$i]['price'] ?></td>
                <td align="center">
                  <?php 
                    echo '<a href="script/print.php?id=' ."{$items[$i]['item_id']}". '" class="btn btn-inverse"><em class="fa fa-file-word-o"></em></a>';
                  ?>
                </td>
                <td align="center">
                  <?php 
                    echo '<a href="script/delete.php?deleteID=' ."{$items[$i]['item_id']}". '" class="btn btn-danger"><em class="fa fa-trash"></em></a>';
                  ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Total-Items <?php echo $totalItems ?></div>
          </div>
        </div>
      </div>
      <!-- End of the panel -->



    </div>
    <!-- End of the column -->
  </div>
  <!-- End of the row -->
  
  <div id="myModal" class="modal fade" role="dialog" style="margin-left: 39%; margin-top: 10%;">
    <div class="​modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Item</h4>
        </div>
        <div class="modal-body">
          <form action="script/add_item.php" method="POST">
            <div class="form-group">
              <label for="title">Item Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Title" required minlength="3" maxlength="50" pattern="[A-Za-z0-9 -]+" size="50">
              <label for="price">Price</label>
              <input type="number" class="form-control" id="price" name="price" placeholder="00.00"  min="0" step="0.01" max="99999999.00" onKeyPress="if(this.value.length==11) return false;">
            </div>
            <button type="submit" class="btn btn-warning pull-right">Add</button>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- End of the container -->






<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>