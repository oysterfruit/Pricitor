 //declaring and linking functions, setting up default data
  jQuery('document').ready(function($){

      var strDate = '';
      strDate = jQuery('#startdateHidden').val();
      var dDate = Date.parse(strDate);
      //strDate = jQuery.datepicker.formatDate('dd M yy', dDate);
      var vMinDate = '01 JUN 2016'; //hardcoded for the moment
      var vMaxDate = '30 SEP 2016';

      //alert("hello!");
      jQuery('#startDate').datepicker({
             dateFormat : 'dd M yy',
             minDate : vMinDate,
             maxDate: vMaxDate
            //defaultDate: '01 JUN 16'

              });


      //save the resort name for display in result header
      jQuery('#resortSelect').change(function () {

              var selectedVal = this.options[this.selectedIndex].text;
              $("#resortNameHidden").val(selectedVal);
              //alert($("#resortNameHidden").text());

                });

      //save the package name for display in result header
      jQuery('input[name=selected_package]:radio').change(function ()  {

              var selId = $('input[name=selected_package]:checked').prop("id");
              jQuery("#packageIdHidden").val(selId);
              //each label wrapping a radio button has the same id as the radio but with an 'l' at the end.
              selId = '#' + selId + '1';
              var pacTxt = jQuery(selId).text();
              jQuery("#packageNameHidden").val(pacTxt);

              });

      //trap the form submit to validate entries
           jQuery('#myForm').submit(function() {


              var bValid = true;

              if (jQuery("#resortNameHidden").val() == ""){
              //display error and don't submit form
              jQuery("#resortError").text("Oops! You need to select a resort.");
                  bValid = false;
              }
               else{
                 //clear error text
                 jQuery("#resortError").text("");
               }


              // var selId = "test";
              var selId = jQuery("#daysSelect").find(':selected').val();

              if (jQuery.isNumeric(selId) == false){
                //display error and don't submit form
                jQuery("#daysError").text("Oops! You need to select # days.");
                  bValid = false;
              }
             else{
                 //clear error text
                 jQuery("#daysError").text("");
               }

             // var selId = "test";
              selId = jQuery("#adultsSelect").find(':selected').val();

              if (selId <1){
                //display error and don't submit form
                jQuery("#adultsError").text("Oops! You need to select at least 1 adult.");
                  bValid = false;
              }
             else{
                 //clear error text
                 jQuery("#adultsError").text("");
               }


              if (isValidDate(jQuery("#startDate"), 'dd M yy') == false){
                //display error and don't submit form
                jQuery("#dateError").text("Oops! You need to select a start date.");
                  bValid = false;
              }
             else{
                 //clear error text
                 jQuery("#dateError").text("");
               }


              if (bValid == false){
                  event.preventDefault();

              }

              });//end form submit function

      //switch tables when previous 7 days button is pressed
  jQuery('#Previous7').click(function() {


        event.preventDefault();
        var i = 1;
        var j = 0;
        var k = 0;
        var leftCol = "";
        var rightCol = "";
        var lcolID = jQuery("#leftColHidden").text();
        var rcolID = jQuery("#rightColHidden").text();


          i = parseInt(lcolID);
          j = i-7;
          if (j < 0){
            j = 0;
          }
          jQuery("#leftColHidden").text(j);
          jQuery("#rightColHidden").text(j+15);
          while (i > j){

            leftCol = 'tcol' + i;
            jQuery('th[name=' + leftCol + ']').removeClass("myHide animated slideInRight");
            jQuery('td[name=' + leftCol + ']').removeClass("myHide animated slideInRight");
            jQuery('th[name=' + leftCol + ']').addClass("animated slideInLeft");
            jQuery('td[name=' + leftCol + ']').addClass("animated slideInLeft");

            k=i+14;
            rightCol = 'tcol' + k;
           // jQuery('th[name=' + rightCol + ']').addClass("animated slideOutRight");
            //jQuery('td[name=' + rightCol + ']').addClass("animated slideOutRight");
            jQuery('th[name=' + rightCol + ']').addClass("myHide");
            jQuery('td[name=' + rightCol + ']').addClass("myHide");

            i = i -1;
            }

            });

      //switch tables when previous 7 days button is pressed
      jQuery('#Next7').click(function() {

        event.preventDefault();
        var i = 1;
        var j = 0;
        var k = 0;
        var leftCol = "";
        var rightCol = "";
        var lcolID = jQuery("#leftColHidden").text();
        var rcolID = jQuery("#rightColHidden").text();
        var totalCols = jQuery("#totalColsHidden").text();

          i = parseInt(rcolID);
          j = i+7;
          totalCols = parseInt(totalCols);
          //can't move past the last column of data
          if (j > totalCols){
            j = totalCols +1 ;
          }

          jQuery("#leftColHidden").text(j-15);
          jQuery("#rightColHidden").text(j);

          while (i < j){

            rightCol = 'tcol' + i;
            jQuery('th[name=' + rightCol + ']').removeClass("myHide animated slideInLeft");
            jQuery('td[name=' + rightCol + ']').removeClass("myHide animated slideInLeft");
            jQuery('th[name=' + rightCol + ']').addClass("animated slideInRight");
            jQuery('td[name=' + rightCol + ']').addClass("animated slideInRight");

            k=i-14;
            leftCol = 'tcol' + k;
           // jQuery('th[name=' + leftCol + ']').addClass("animated slideOutLeft");
            //jQuery('td[name=' + leftCol + ']').addClass("animated slideOutLeft");
            jQuery('th[name=' + leftCol + ']').addClass("myHide");
            jQuery('td[name=' + leftCol + ']').addClass("myHide");

            i = i+1;
            }


              });

    //set the selection based on what was submitted
    //values are read from the $_POST object into hidden fields via PHP
    //and read from those fields to set the correct options here.

    //alert("here!");
    var vPack = jQuery('#packageIdHidden').val();
    jQuery('#' + vPack).prop('checked', true);

    var vRes = jQuery('#resortHidden').val();
    jQuery('#resortSelect option[value=' + vRes + ']').prop('selected','selected');

    var vDays = jQuery('#daysHidden').val();
    jQuery('#daysSelect option[value=' + vDays + ']').prop('selected','selected');

    var vAdults = jQuery('#adultsHidden').val();
    jQuery('#adultsSelect option[value=' + vAdults + ']').prop('selected','selected');

    var vKids = jQuery('#kidsHidden').val();
    jQuery('#kidsSelect option[value=' + vKids + ']').prop('selected','selected');


    //highlight the cheapest price row
    var rowID = jQuery("#cheapestRow").text();
    var startColID = jQuery("#selectedColStart").text();
    var endColID = jQuery("#selectedColEnd").text();
    var i = parseInt(startColID);
    var j = parseInt(endColID);

     //highlight total for cheapest retailer
    jQuery('tr[name=cost' + rowID + '] > td[name=colTotal]').addClass('success');

    while (i <= j){
        jQuery('tr[name=cost' + rowID + '] > td[name=tcol' + i + ']').removeClass('info');
        jQuery('tr[name=cost' + rowID + '] > td[name=tcol' + i + ']').addClass('success');
        i = i+1;
      }

    //if the table exists scroll to the table

    if (jQuery('#tableBlurb').length) {
       //alert("here!");
        var new_position = jQuery('#tableBlurb').offset();
     //spent ages trying to get this to work on Chrome and Safari - yay for stackoverflow!
      window.setTimeout(function() {
      window.scrollTo(new_position.left,new_position.top-100);
      }, 0);

    }

  }); //end document ready function

  function isValidDate(controlName, format){
    var isValid = true;

    try{
        jQuery.datepicker.parseDate(format, jQuery(controlName).val(), null);
    }
    catch(error){
        isValid = false;
    }

    return isValid;
}
