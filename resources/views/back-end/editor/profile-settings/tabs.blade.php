<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="{{{ \Request::route()->getName()==='personalDetail'? 'active': '' }}}" href="{{{ route('editorProfile') }}}">{{{ trans('lang.personal_detail') }}}</a>
        </li>
       
    </ul>
</div>


<!-- Modal -->
<div class="modal fade" id="preview" role="dialog">
    <div class="modal-dialog modal-lg">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Profile Preview</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"> 
		<div class="row">
			<div class="col-md-12">
				<iframe src="{{ 'https://ebelong.com/profile/'.auth::user()->slug }}?is_preview=1" style="width:100%height:auto;" ></iframe>	
			</div>
		</div> 
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
 </div>

