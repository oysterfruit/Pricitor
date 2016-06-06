<!-- start of results table area -->
  <!-- <div class="first-background"> around the results area-->
  <div class="container add-end-gap">

<div id= "tableWell" class="well well-lg">
    <div class="table-responsive" id="priceTable">
      <h1 id="tableBlurb" class="text-center">Best Deals for <b><?PHP echo $packageName; ?></b> heading to <b><?PHP echo $resortName; ?></b> picking up on <b><?php echo date_format(date_create($startdate),"M d");?></b></h1>
      <nav>
  <ul class="pager pad-left-160">
    <li class="previous" id = "Previous7"><a href="#"><span aria-hidden="true">&larr;</span> Previous 7 days</a></li>
    <li class="next" id ="Next7"><a href="#">Next 7 days<span aria-hidden="true">&rarr;</span></a></li>
  </ul>
  </nav>
      <table id= "table1" class="table table-striped table-condensed">

          <?php
              include 'PricitorHeaders.php';
          ?>

      </table>
      <!-- store values of hidden columns, total column,the row with the lowest price, colindex of the start and end of selected dates-->
      <div class="myHide" id="leftColHidden"><?php echo htmlspecialchars($left_col_hidden);?></div>
      <div class="myHide" id="rightColHidden"><?php echo htmlspecialchars($right_col_hidden);?></div>
      <div class="myHide" id="totalColsHidden"><?php echo htmlspecialchars($total_cols_hidden);?></div>
      <div class="myHide" id="cheapestRow"><?php echo htmlspecialchars($cheapest_row);?></div>
      <div class="myHide" id="selectedColStart"><?php echo htmlspecialchars($selected_col_start);?></div>
      <div class="myHide" id="selectedColEnd"><?php echo htmlspecialchars($selected_col_end);?></div>

</div>
</div>
    </div>
  <!-- </div> -->


