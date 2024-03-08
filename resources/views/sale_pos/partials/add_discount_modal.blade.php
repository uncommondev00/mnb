<!-- Edit discount Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="posAddDiscountModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title"  >@lang('Add Discount')</h4>
			</div>
			<div class="modal-body">
		
		<div id="add_discount_section">
			<div class="form-group row" align="center">
                	<div class="col-md-12">
						<div class="col-md-12 text-center">
							<b><label>For Senior Citizen Only!</label></b>
						</div>
						<b><div id="error_msg" style="color: red"></div></b>
						<div class="col-md-1">
						</div>
						<div class="col-md-10 text-center">
							<div class="input-group text-center">
							    <span class="input-group-addon">
							        <i class="fa fa-id-card"></i> ID # : 
							    </span>
							    <input type="text" id="s_id" name="s_id" class="form-control"  >
							</div>
						   
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-1">
						</div>
						<div class="col-md-10 text-center spacer" >
							<div class="input-group text-center">
							    <span class="input-group-addon " >
							        <i class="fa fa-edit"></i> Name :       
							    </span>
							    <input type="text" id="s_name" name="s_name" class="form-control"  >
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-1">
						</div>
						<div class="col-md-10 text-center spacer">
							<div class="input-group text-center">
							    <span class="input-group-addon">
							        <i class="fa fa-map-marker"></i> Address : 
							    </span>
							    <input type="text" id="s_addr" name="s_addr" class="form-control"  >
							</div>
						</div>						
					</div>
				</div>
         </div>

		<div id="add_discount_section_1">
              <center>
                <div class="form-group row" align="center">

                    <div class="col-md-12 text-center " >
                      <div class="col-md-4 text-center " >

                        
                      </div>
                       <div class="col-md-4 text-center " >
                        <b><div id="Check_discount_PIN" style="color: red"></div></b>
                         <input class="form-control text-center" type="password" name="RNPassword" placeholder="Enter Pincode" id="input_discount_PIN" >
                       </div>
                       <div class="col-md-4 text-center " ></div>
                    </div>  
                </div>
                <div> 
                    <button type="button" class="btn btn-success" id="dis_pin"  onclick="myPin();"> Verify</button> 
                </div>
              </center>
         </div>
		
		<div id="add_discount_section_2">
			<center>
				<div class="form-group row" align="center">
					<div class="col-md-12 text-center " >
						<div class="col-md-4 text-center " ></div>
						    <div class="col-md-4 text-center">
						            {!! Form::label('discount_amount_modal', __('Discount Percentage') . ':*' ) !!}
						            <div class="input-group text-center">
						                <span class="input-group-addon">
						                    <i class="fa fa-info"></i>
						                </span>
						                <input type="text" id="discount_value_modal" class="form-control input_number" value="0">
						            </div>
						    </div>
					    <div class="col-md-4 text-center " ></div>
					</div>



				</div>
			</center>
		</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_cancel">@lang('Cancel')</button>
				
				<button type="button" class="btn btn-primary" onclick="input_valid();"  id="btn_ok">@lang('OK')</button>

				<button type="button" class="btn btn-primary" onclick="checkCookie();" data-dismiss="modal" id="btn_add_discount">@lang('messages.update')</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
