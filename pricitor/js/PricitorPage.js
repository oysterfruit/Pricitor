 //declaring and linking funcions, setting up default data
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
           /* jQuery('#myForm').submit(function() {

              event.preventDefault();
              var bValid = true;

              alert("here!");
              if (jQuery("#resortNameHidden").val() == ""){

              //display error and don't submit form
              jQuery("#resortError").text("Oops! You need to select a resort");

                bValid = false;

                }

              if (bValid == false){
                  event.preventDefault();

              }

              });//end form submit function*/

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


    var vPack = jQuery('#packageIdHidden').val();
    jQuery('#' + vPack).prop('checked', true);

    var vRes = jQuery('#resortHidden').val();
    jQuery('#resortSelect option[value=' + vRes + ']').prop('selected','selected');

    var vDays = jQuery('#daysHidden').val();
    jQuery('#daysSelect option[value=' + vDays + ']').prop('selected','selected');

    var rowID = jQuery("#cheapestRow").text();
    var startColID = jQuery("#selectedColStart").text();
    var endColID = jQuery("#selectedColEnd").text();


    var i = parseInt(startColID);
    var j = parseInt(endColID);
    while (i <= j){
        jQuery('tr[name=cost' + rowID + '] > td[name=tcol' + i + ']').addClass('highlight_price');
        i = i+1;
      }

  }); //end document ready function
