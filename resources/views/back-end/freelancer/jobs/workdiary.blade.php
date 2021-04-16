@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

 <div class="wt-haslayout wt-dbsectionspace">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left" id="workdiary">

        	  <div class="wt-haslayout wt-post-job-wrap">
        	  	 {!! Form::open(['url' => '', 'class' =>'wt-haslayout', 'id' => 'post_workdiary_form',  '@submit.prevent'=>'SubmitWorkDiary']) !!}
                <div class="wt-dashboardbox">

        	  	 <div class="wt-dashboardboxtitle">
                            <h2>Work Diary</h2>
                        </div>

                        <div class="wt-jobcategories wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>Project Title:<strong style="margin-left:20px; color:#2ecc71;">    {{$project_title->title}} </strong></h2>
                                    <input type="hidden" name="slug" id="slug" value="{{$project_title->slug}}">
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                       <!-- <span class="wt-select">
                                             <select name="project_id">
                                            <?php if(!empty($projects)) { ?>
                                            <option selected="selected" value="">Select Project</option>
                                            <?php foreach($projects as $key => $project) { ?>
                                            <option value="<?php echo $project['id'];?>"><?php echo $project['title'];?></option>
                                            <?php } ?>
                                            <?php }else {  ?>
                                                <option selected="selected" value="">No Project</option>
                                            <?php } ?>	
                                        </select>	 
                                        </span>  -->
                                    </div>
                                </div>
                            </div>

                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>Date: <?php echo date("l -  d/m/Y", strtotime($date)); ?></h2>
                                    <input type="hidden" name="project_id" id="project_id" class="form-control" readonly="true" value="<?php echo $project_title->id; ?>">
                                    <input type="hidden" name="date" class="form-control" readonly="true" value="<?php echo $date; ?>">
                                </div>
                               <!-- <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                       <div class="form-group form-group-half wt-formwithlabel">
                                            <span class="">
                                               <input type="date" name="date" class="form-control">
                                            </span>
                                        </div>
                                        
                                    </fieldset>
                                </div> -->
                            </div> 

                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2 style="text-transform: none;">Your weekly contract hours are :  <?php echo "<strong>" . $project_title->no_of_hours . " " . 'hours / week' . "</strong>" ; ?>  </h2>

                                </div>
                            </div>

                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2 style="text-transform: none;">Hired On :  <?php $new_date = $project_title->hired_date; 

                                         $date =  date("l -  d/m/Y,",  strtotime($new_date));
                                    	 echo $date;

                                         $time =  date("H:i A",  strtotime($new_date));  
                                         echo "<mark>". "<strong>" . $time . "</strong>" . "</mark>";

                                         ?> (UTC) - Please make sure your time entries are added after your hiring time. </h2>

                                </div>
                            </div>                            


                            <div class="form-group form-group-half wt-formwithlabel">
                                <div class="wt-tabscontenttitle">
                                    <h2>Start Time</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="">
                                        <!--  <input type="" name="title" class="form-control"> -->
                                        <input id="start_time" name="start_time" type="text" class="time" placeholder="12:00 AM" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-half wt-formwithlabel">
                                <div class="wt-tabscontenttitle">
                                    <h2>End Time</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="">
                                             <!-- <input type="text" name="title" class="form-control" placeholder="0"> -->
                                             <input id="end_time" name="end_time" type="text" class="time" placeholder="12:00 AM" />
                                        </span>
                                    </div>
                                </div>
                            </div>

                             <div  class="form-group form-group-half wt-formwithlabel" style="display: flex;">
                                 <div class="wt-tabscontenttitle" style="display: flex; "> 
                                    <h2 style="text-transform: none;">Hours reporting</h2> 
                                
                                       <div style="margin-left:165px"> <h2 id="hours"> 00 </h2>    </div>
                                       <div style="margin-left:5px"> <h2> :   </h2>           </div> 
                                       <div style="margin-left:5px"> <h2 id="minutes">00  </h2>  </div>
                                        <div style="margin-left:5px"> <h2 id="minutes">hrs  </h2>  </div>
                                
                                </div> 
                             </div>


                            <div class="wt-jobdetails wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2 style="text-transform: none;">Activities: Job Description to Activities</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    {!! Form::textarea('description', null, ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.service_desc_note')]) !!}
                                </div>
                            </div>
                             <div class="wt-updatall">
                        <i class="ti-announcement"></i>
                        <span>Post work hours now</span>
                        {!! Form::submit('Post Hours', ['class' => 'wt-btn', 'id'=>'submit-service']) !!}
                    </div>
                            


                        
                        </div>
                        {!! form::close(); !!}
                    </div>
                </div>
            </div>
        </div>



@endsection

