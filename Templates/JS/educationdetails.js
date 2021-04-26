$("#tenthmarkdropdown").change(function() {
    if ($(this).val() == "CGPA") {
      $('#otherFieldGroupDivcten').show();
      $('#otherFieldGroupDivpten').hide();
      
    } else if($(this).val() == "Perc") {
      $('#otherFieldGroupDivpten').show();
      $('#otherFieldGroupDivcten').hide();
    }
    else{
        $('#otherFieldGroupDivcten').hide(); 
        $('#otherFieldGroupDivpten').hide();
    }
  });
  $("#tenthmarkdropdown").trigger("change");


  $("#twmarkdropdown").change(function() {
    if ($(this).val() == "CGPA") {
      $('#twmarkcgpa').show();
      $('#twmarkperc').hide();
      
    } else if($(this).val() == "Perc") {
      $('#twmarkperc').show();
      $('#twmarkcgpa').hide();
    }
    else{
        $('#twmarkperc').hide(); 
        $('#twmarkcgpa').hide();
    }
  });
  $("#twmarkdropdown").trigger("change");