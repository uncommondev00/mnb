<div class="modal fade" id="x_reading_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">@lang('X Reading')</h4>
      </div>
      <div class="modal-body">
            <div id="security_section">
                <center>
                  <div class="form-group row" align="center">
                      <div class="col-md-12 text-center">
                        <div class="col-md-4 text-center"></div>
                          <div class="col-md-4 text-center">
                            <b><div id="Check_xreading_PIN" style="color: red"></div></b>
                              <input class="form-control text-center" type="password" name="RNPassword" placeholder="Enter Pincode" id="input_xreading_PIN" >
                          </div>
                         <div class="col-md-4 text-center"></div>
                      </div>  
                  </div>
                  <div> 
                    <button type="button" class="btn btn-success" id="x_pin" onclick="myXPin();"> Verify </button>
                  </div>
                </center>
            </div>

      </div>
      <div class="modal-footer">
       
      </div>
     
    </div>
  </div>
</div>




