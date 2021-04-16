@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    @php
        $count = 0;
        $reviews = \App\Review::where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
        $project_type  = Helper::getProjectTypeList($job->project_type);
    @endphp
    <section class="wt-haslayout wt-dbsectionspace" id="jobs">
        <div class="preloader-section" v-if="loading" v-cloak>
            <div class="preloader-holder">
                <div class="loader"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @if (Session::has('success'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('success') }}}'" v-cloak></flash_messages>
                    </div>
                    @php session()->forget('success'); @endphp
                @elseif (Session::has('error'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>Work Diary</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-freelancerholder wt-tabsinfo">
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                    @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                        <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                    @endif
                                    <div class="wt-userlistingcontent">
                                        <div class="wt-contenthead">
                                            @if (!empty($employer_name) || !empty($job->title) )
                                                <div class="wt-title">
                                                    @if (!empty($employer_name))
                                                        <a href="{{{ url('profile/'.$job->employer->slug) }}}">@if ($verified_user === 1)<i class="fa fa-check-circle"></i>@endif&nbsp;{{{ $employer_name }}}</a>
                                                    @endif
                                                    @if (!empty($job->title))
                                                        <h2>{{{ $job->title }}}</h2>
                                                    @endif
                                                </div>
                                            @endif
                                            @if (!empty($job->price) ||
                                                !empty($job->location->title))
                                                <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                    @if (!empty($job->price))
                                                        <li><span class="wt-dashboraddoller"><i>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}</i> {{{ $job->price }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->location->title))
                                                        <li><span><img src="{{{asset(App\Helper::getLocationFlag($job->location->flag))}}}" alt="{{ trans('lang.img') }}"> {{{ $job->location->title }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->project_type))
                                                        <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> {{ trans('lang.type') }} {{{ $project_type }}}</a></li>
                                                    @endif
                                                    @if (!empty($job->duration))
                                                        <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ $duration }}}</span></li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="wt-rightarea">
                                            
                                                     @php
                                                        session()->put(['total_hours' => e($total_hours)]);
                                                                                                               
                                                        @endphp

                                            @if ($job->status === 'hired')
                                                <div class="wt-hireduserstatus">
                                                    <h4>{{ trans('lang.hired') }}</h4>
                                                    <span>{{{ $freelancer_name }}}</span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            @elseif ($job->status === 'completed')
                                                <div class="wt-hireduserstatus">
                                                    <h4>{{ trans('lang.completed') }}</h4>
                                                    <span>{{{ $freelancer_name }}}</span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="wt-hireduserstatus">
                                                    @if (Auth::user()->getRoleNames()[0] == "admin")
                                                        <h4>{{ trans('lang.job_cancelled') }}</h4>
                                                    @else
                                                        <h5>{{ trans('lang.no_freelancers') }}</h5>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <?php $wallet_amount = $total_job_wallet_amount; ?>
                                        <div class="wt-rightarea">
                                             <div class="wt-hireduserstatus">
                                          <h4>  Wallet Amount </h4>
                                          <span><h3> $<?php echo $total_job_wallet_amount; ?> </h3> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Previous Bill Work Start-->
                        <?php if(!empty($previous_hours_data)) { ?>
                        <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                            <div class="wt-tabscontenttitle">
                                <h2>Timesheet For  <?php echo(date('F',strtotime($previous_hours_data['week_hours']['Monday']['date']))); ?>
                                    <?php echo(date('j',strtotime($previous_hours_data['week_hours']['Monday']['date'])));?>
                                    -
                                    <?php echo(date('j',strtotime($previous_hours_data['week_hours']['Sunday']['date'])));?>
                                </h2> 
                            </div>
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-proposalitem">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th><?php echo $previous_hours_data['week_hours']['Monday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Monday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Tuesday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Tuesday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Wednesday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Wednesday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Thursday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Thursday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Friday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Friday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Saturday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Saturday']['date']; ?></th>
                                                <th><?php echo $previous_hours_data['week_hours']['Sunday']['day']; ?> - <?php echo $previous_hours_data['week_hours']['Sunday']['date']; ?></th>

                                                <?php //} ?>
                                                <th>Hours</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $previous_hours_data['week_hours']['Monday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $previous_hours_data['week_hours']['Tuesday']['no_of_hours']; ?> </td> 
                                                <td><?php echo $previous_hours_data['week_hours']['Wednesday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $previous_hours_data['week_hours']['Thursday']['no_of_hours']; ?></td>
                                                <td> <?php echo $previous_hours_data['week_hours']['Friday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $previous_hours_data['week_hours']['Saturday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $previous_hours_data['week_hours']['Sunday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $previous_hours_data['total_hours'] ?></td>
                                                <td>${{{ $accepted_proposal->amount }}}.00 / hr</td> 
                                                <td>$<?php echo ($previous_hours_data['total_hours']*$accepted_proposal->amount) ?></td>
                                                <td><?php echo $previous_hours_data['is_show_pay_button'] == 1 ? "Pending": "<strong style=color:#2ecc71;>" . "Paid" . "</strong>"; ?> </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                    <div class="wt-rightarea">
                                        <div class="wt-btnarea" style="margin-right: 15px;">
                                            <?php if($previous_hours_data['is_show_pay_button']) {?>
                                            <a href="{{{ url ('employer/bill/workdiary/' .  $job->id.'/'.date('Y-m-d',strtotime($previous_hours_data['week_hours']['Monday']['date'])).'/'.date('Y-m-d',strtotime($previous_hours_data['week_hours']['Sunday']['date']))) }}}" class="wt-btn">Pay Now</a>
                                            <?php }else{ ?>
                                                <!-- <h6>Bill Payed</h6> -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Previous Bill Work End-->

                        <!-- <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo"> -->
                            <!-- <div class="wt-tabscontenttitle">
                                <h2>
                                    @php 
                                $currentdate = date("m/d/Y");
                                $date = $currentdate;
                                $ts = strtotime($date);
                                $month = date('F');
                                $dow = date('w', $ts);
                                $offset = $dow - 1;
                                if ($offset < 0) {
                                    $offset = 6;
                                }
                                $ts = $ts - $offset*86400;

                                 echo "Timesheet For". " " . $month .  " ";

                                for ($i = 0 ; $i<7; $i++, $ts += 86400){
                                       if ($i == '0' ) { 
                                       $current_start_week_day = date("Y-m-d", $ts);
                                     print date("j", $ts);
                                     echo " - " ;
                                 } elseif ($i == '6'){
                                 $current_end_week_day = date("Y-m-d", $ts);
                                    print date("j", $ts);
                                 }
                                }  

                                echo " (This Week)" ;   

                               @endphp 

                                </h2>
                            </div> -->
                            <!-- <div class="wt-jobdetailscontent">
                               
                                    <div class="wt-userlistinghold wt-featured wt-proposalitem">

                                        <table>
                                              <tr>
                                                
                                                @php 

                                                $bill_hours = App\WorkDiary::where('status', 'pending')->get()->all();
                                                if(!empty($bill_hours))
                                                    $hours_date = Carbon\Carbon::parse($bill_hours[0]->date)->format('d/m');
                                                $currentdate = date('m/d/Y');
                                                $date = $currentdate;
                                                $ts = strtotime($date);
                                             
                                                $dow = date('w', $ts);
                                                $offset = $dow - 1;
                                                if ($offset < 0) {
                                                    $offset = 6;
                                                }
                                             
                                                $ts = $ts - $offset*86400;
                                                for ($i = 0; $i < 7; $i++, $ts += 86400){
                                                   
                                                    echo  "<th>";
                                                    $date = date("l - d/m", $ts);
                                                    print ($date);
                                                 
                                                }
                                                 

                                                echo "</th>";
                                                echo "<th>";
                                                echo "Hours";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Rate";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Amount";
                                                echo "</th>"; 
                                                echo "<th>";
                                                echo "Wallet Amount";
                                                echo "</th>"; 
                                                echo "<th>";
                                                echo "Total Amount";
                                                echo "</th>"; 
                                                echo "</tr>";
                                                
                                                @endphp 

                                             @if ($week_days['Monday'] = 'Monday')
                                                <td>{{{$monday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Tuesday'] = 'Tuesday')
                                                <td>{{{$tuesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Wednesday'] = 'Wednesday')
                                                <td>{{{$wednesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Thursday'] = 'Thursday')
                                                <td>{{{$thursday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Friday'] = 'Friday')
                                                <td>{{{$friday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif                                                
                                                @if ($week_days['Satruday'] = 'Saturday')
                                                <td>{{{$saturday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                @if ($week_days['Sunday'] = 'Sunday')
                                                <td>{{{$sunday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                <td>{{{ $total_hours }}}<td>
                                                {{{ $accepted_proposal->amount }}}.00 / hr
                                                <td>${{{$total_hours * $accepted_proposal->amount }}}</td>
                                                 <td>$<?php echo $wallet_amount; ?></td>
                                                  <td>$
                                                    <?php if($wallet_amount > ($total_hours * $accepted_proposal->amount)) {  ?>
                                                        0
                                                    <?php } else if(($total_hours * $accepted_proposal->amount) > 0) { ?>
                                                    <?php  echo ($total_hours * $accepted_proposal->amount) - $wallet_amount?>
                                                    <?php } else { ?>
                                                        <?php  echo ($total_hours * $accepted_proposal->amount)?>
                                                    <?php } ?>

                                                    

                                               </tr>

                                              </tr>
                                          </table>
                                          <h6 style="text-transform: none;">Note: Your weekly bill will be displayed on Monday 11:59 AM (UTC).</h6>
                                        <div class="wt-rightarea">
                                        <div class="wt-btnarea">
                                                     <?php if($show_current_week_pay_out_button == 1) { ?>
                                                     <a href="{{{ url ('employer/bill/workdiary/' .  $job->id.'/'.$current_start_week_day.'/'.$current_end_week_day) }}}" class="wt-btn">Pay Now</a>
                                                     <?php }elseif($show_current_week_pay_out_button == 2){ ?>
                                                       <h6>Bill Payed</h6>
                                                     <?php } ?>
                                                    </div>
                                                </div>
			                            </div>
			                        </div> -->
			                      <!-- </div> -->


			                       <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                                            <div class="wt-tabscontenttitle" style="display:flex; width:35%;">
                                                <!--  <h2>Timesheet for Jun 1 - 7 (this week)</h2> -->
                                                <h2>  Billing History </h2>
                                   </div>
                              
                               <div class="form-group form-group-half wt-formwithlabel" style="margin-left: 222px">
                                <div class="wt-tabscontenttitle" style="display:flex; width:33%; height:40px">
                                    <h2>To</h2>
                               
	                                <div class="wt-divtheme wt-userform wt-userformvtwo">
	                                    <div class="form-group">
	                                        <span class="">
	                                        <!--  <input type="" name="title" class="form-control"> -->
	                                        <input id="start_date" name="start_time" type="text" class="time" placeholder="" style="height:25px"; />
	                                        </span>
	                                    </div>
	                                </div>
                              </div> 

                                <div class="wt-tabscontenttitle" style="display:flex; width:33%; height:40px;margin-left: 65px;">
                                    <h2>From</h2>
                              
		                                <div class="wt-divtheme wt-userform wt-userformvtwo">
		                                    <div class="form-group" >
		                                        <span class="">
		                                             <!-- <input type="text" name="title" class="form-control" placeholder="0"> -->
		                                            <input id="end_date" name="end_time" type="text" class="time" placeholder="" style="height:25px"; />
		                                        	  <input type="hidden" id="job_id" name="job_id" value="<?php echo $job->id;?>">                                 
		                                         </span>
		                                      </div>
		                                 </div>
		                                 	  
		                                 	 <a  onclick="filter_function();" class="" > <div class="go-wt-btn" style="background-color:#62BE8F;color:#fff;width:65px; border-radius: 5px; font:700 13px 'Poppins', Arial, Helvetica, sans-serif; position: relative;
text-align: center;height: 25px; padding-top: 3px; margin-left: 65px;">                 	  	GO 
		                                 	  </div>
		                                 	  	</a>
		                                 	   <!-- <div class="wt-rightarea">
		                                            <div class="wt-btnarea"  style="margin-right: 15px;">
		                                                 <a href="" class="wt-btn" sytle="color:#fff">GO</a>
		                                             </div>
		                                         </div> -->

                                 </div>                            
                           </div>

                           			
                          
                                            
                                                <!-- start -->
                        <?php foreach($project_hours_data as $key => $value) { ?>
                        <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                           <!-- <div class="wt-tabscontenttitle">
                              <div>Timesheet For <?php  //echo $value['week_hours']['Monday']['date']; ?> -  <?php  // echo $value['week_hours']['Sunday']['date']; ?></div>  -->
                              <div class="wt-tabscontenttitle">
                               <h2>
                                    @php 
                                $currentdate = date("m/d/Y");
                                $date = $value['week_hours']['Monday']['date'];
                                $ts = strtotime($date);

                                $month = date('F', $ts);
                                $dow = date('w', $ts);
                                $offset = $dow - 1;
                                if ($offset < 0) {
                                    $offset = 6;
                                }
                                $ts = $ts - $offset*86400;

                                 echo "Timesheet For". " " . $month .  " ";

                                for ($i = 0 ; $i<7; $i++, $ts += 86400){
                                       if ($i == '0' ) { 
                                     print date("j", $ts);
                                     echo " - " ;
                                 } elseif ($i == '6'){
                                    print date("j", $ts);
                                 }
                                }  
                                
                               @endphp 

                                </h2> 
                           
                          </div>
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-proposalitem">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <?php //foreach($value['week_hours'] as $key1 => $value1) { ?>
                                                <th><?php echo $value['week_hours']['Monday']['day']; ?> - <?php echo $value['week_hours']['Monday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Tuesday']['day']; ?> - <?php echo $value['week_hours']['Tuesday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Wednesday']['day']; ?> - <?php echo $value['week_hours']['Wednesday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Thursday']['day']; ?> - <?php echo $value['week_hours']['Thursday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Friday']['day']; ?> - <?php echo $value['week_hours']['Friday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Saturday']['day']; ?> - <?php echo $value['week_hours']['Saturday']['date']; ?></th>
                                                <th><?php echo $value['week_hours']['Sunday']['day']; ?> - <?php echo $value['week_hours']['Sunday']['date']; ?></th>

                                                <?php //} ?>
                                                <th>Hours</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                             
                                            <tr>
                                                <td> <?php echo $value['week_hours']['Monday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $value['week_hours']['Tuesday']['no_of_hours']; ?> </td> 
                                                <td><?php echo $value['week_hours']['Wednesday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $value['week_hours']['Thursday']['no_of_hours']; ?></td>
                                                <td> <?php echo $value['week_hours']['Friday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $value['week_hours']['Saturday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $value['week_hours']['Sunday']['no_of_hours']; ?> </td> 
                                                <td> <?php echo $value['total_hours'] ?></td>
                                                <td>${{{ $accepted_proposal->amount }}}.00 / hr</td> 
                                                <td>$<?php echo ($value['total_hours']*$accepted_proposal->amount) ?></td>
                                                <td><?php echo $value['is_show_pay_button'] == 1 ? "Pending": "Paid"; ?> </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table> 

                                    <div class="wt-rightarea">
                                        <div class="wt-btnarea" style="margin-right: 15px;">
                                            <?php if($value['is_show_pay_button']) {?>
                                            <a href="{{{ url ('employer/bill/workdiary/' .  $job->id.'/'.date('Y-m-d',strtotime($value['week_hours']['Monday']['date'])).'/'.date('Y-m-d',strtotime($value['week_hours']['Sunday']['date']))) }}}" class="wt-btn">Pay Now</a>
                                            <?php }else{ ?>
                                                <!-- <h6>Bill Payed</h6> -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php } ?>
                         <!-- end -->
                                        

                                        
					                   </div>
					                </div>
					            </div> 



                </div>
            </div>

     <!--  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            </div>
        </div>
        <b-modal ref="myModalRef-{{ $accepted_proposal->id }}" hide-footer title="Cover Letter" v-cloak>
            <div class="d-block text-center">
                {{{$accepted_proposal->content}}}
            </div>
        </b-modal>
        <b-modal ref="myModalRef" hide-footer title="Project Status">
            <div class="d-block text-center">
                <form class="wt-formtheme wt-formfeedback" id="submit-review-form">
                    <fieldset>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="{{ trans('lang.add_your_feedback') }}" name="feedback"></textarea>
                        </div>
                        @if(!empty($review_options))
                            @foreach ($review_options as $key => $option)
                                <div class="form-group wt-ratingholder">
                                    <div class="wt-ratepoints">
                                        <vue-stars
                                            :name="'rating[{{$key}}][rate]'"
                                            :active-color="'#fecb02'"
                                            :inactive-color="'#999999'"
                                            :shadow-color="'#ffff00'"
                                            :hover-color="'#dddd00'"
                                            :max="5"
                                            :value="0"
                                            :readonly="false"
                                            :char="'★'"
                                            id="rating-{{$key}}"
                                        />
                                        <div class="counter wt-pointscounter"></div>
                                    </div>
                                    <input type="hidden" name="rating[{{$key}}][reason]" value="{{{$option->id}}}">
                                    <span class="wt-ratingdescription">{{{$option->title}}}</span>
                                </div>
                            @endforeach
                        @endif
                        <input type="hidden" name="receiver_id" value="{{{$accepted_proposal->freelancer_id}}}">
                        <input type="hidden" name="proposal_id" value="{{{$accepted_proposal->id}}}">
                        <div class="form-group wt-btnarea">
                            <a class="wt-btn" href="javascript:void(0);" v-on:click='submitFeedback({{$accepted_proposal->freelancer_id}}, {{$job->id}})'>{{ trans('lang.btn_send_feedback') }}</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </b-modal> -->
    </section>
    <script type="text/javascript">
        function filter_function()
        {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var job_id = $('#job_id').val();
            if(start_date == "" || end_date == "")
            {
                alert("please fill the start and end date filled");
            }
            else
            {
                var break_start_date = start_date.split("/");
                var formate_start_date = break_start_date[2]+"-"+break_start_date[0]+"-"+break_start_date[1];

                var break_end_date = end_date.split("/");
                var formate_end_date = break_end_date[2]+"-"+break_end_date[0]+"-"+break_end_date[1];
                //console.log(window.location.origin);
                window.location = ''+job_id +'?filter=1&start_date='+formate_start_date+'&end_date='+formate_end_date;
            }

        }
    </script>
    @endsection