<div class="modal fade" id="open_drawer_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">{{ config('app.name', 'ultimatePOS') }}</h4>
      </div>
      <div class="modal-body">
            <div id="security_section1">
                <center>
                  <div class="form-group row" align="center">
                      <div class="col-md-12 text-center">
                        <div class="col-md-4 text-center"></div>
                          <div class="col-md-4 text-center">
                            <b><div id="open_drawer_PIN" style="color: red"></div></b>
                              <input class="form-control text-center" type="password" name="RNPassword" placeholder="Enter Pincode" id="input_open_PIN" >
                          </div>
                         <div class="col-md-4 text-center"></div>
                      </div>  
                  </div>
                  <div> 
                    <button type="button" class="btn btn-success"  onclick="myPin2();"> Verify </button>
                  </div>
                </center>
            </div>

            <div id="security_section2">
                <center>
                  <div> 
                    <button type="button" class="btn btn-success" id="open_pin" onclick="opened();"> Open </button>
                  </div>
                </center>
            </div>

      </div>
      <div class="modal-footer">
       
      </div>
     
    </div>
  </div>
</div>
