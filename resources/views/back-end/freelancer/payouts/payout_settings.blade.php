@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    {{-- @php
        echo "<pre>";
            print_r(Auth::user()); 
        echo "</pre>";
    @endphp --}}
    <div class="wt-dbsectionspace wt-haslayout la-ps-freelancer">
        <div class="freelancer-profile" id="invoice_list">
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <div class="wt-dashboardbox wt-dashboardtabsholder">
                        @if (file_exists(resource_path('views/extend/back-end/freelancer/payouts/tabs.blade.php')))
                            @include('extend.back-end.freelancer.payouts.tabs')
                        @else
                            @include('back-end.freelancer.payouts.tabs')
                        @endif
                        <div class="wt-tabscontent tab-content">
                            <div class="wt-tabscontenttitle">
                                <h2>{{ trans('lang.payout_settings') }}</h2>
                            </div>
                            <div class="wt-settingscontent">
                                <div class="wt-description">
                                    <p>{{ trans('lang.payout_settings_note') }}</p>
                                </div>
                                <form class="wt-formtheme wt-payout-settings la-payout-settings" @submit.prevent="submitPayoutsDetail({{Auth::user()->id}})" id="profile_payout_detail">
                                        @if( !empty($payrols) )
                                            @foreach ($payrols as $pay_key	=> $payrol)
                                                @php
                                                    $vue_display = $payrol['id'] == 'bacs' ? 'show_bank_fields' : 'show_paypal_fields';
                                                    $checked =  $payout_settings['type'] == $payrol['id'] ? 'checked' : '';
                                                @endphp
                                                @if( !empty($payrol['status']) && $payrol['status'] === 'enable' )
                                                    <fieldset>
                                                        <div class="wt-checkboxholder">
                                                            <span class="wt-radio">
                                                                <input id="payrols-{{$payrol['id']}}" type="radio" name="payout_settings[type]" value="{{$payrol['id']}}" v-on:change="changePayout('{{$payrol['id']}}')" {{$checked}}>
                                                                <label for="payrols-{{$payrol['id']}}">
                                                                    <figure class="wt-userlistingimg">
                                                                        <img src="{{$payrol['img_url']}}" alt="{{$payrol['title']}}">
                                                                    </figure>
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <div class="fields-wrapper wt-haslayout" v-if="{{$vue_display}}">
                                                            <div class="wt-description">
                                                                @if ($payrol['id'] == 'paypal')
                                                                    <p>{{ trans('lang.paypal_payout_id_text') }} <a target="_blank" href="https://www.paypal.com/"> {{ trans('lang.paypal') }} </a> | <a target="_blank" href="https://www.paypal.com/signup/">{{ trans('lang.payout_id_create_acc') }}</a></p>
                                                                @elseif ($payrol['id'] == 'bacs')
                                                                    <p>{{ trans('lang.bank_payout_id_text') }}</p>
                                                                @endif
                                                            </div>
                                                           {{-- @if( !empty($payrol['fields']))
                                                                @foreach( $payrol['fields'] as $key => $field )
                                                                   @php $db_value	= !empty($payout_settings[$key]) ? $payout_settings[$key] : ""; @endphp
                                                                <div class="form-group form-group-half toolip-wrapo">
                                                                   <input type="{{$field['type']}}" name="payout_settings[{{$key}}]" id="{{$key}}-payrols" class="form-control" placeholder="{{$field['placeholder']}}" value="{{$db_value}}">
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                            --}}
                                                            @if($payrol['id'] == 'bacs')
                                                                @php
                                                                    if(!isset($payout_settings)){
                                                                        $payout_settings = array();
                                                                    }
                                                                    if(!array_key_exists('email',$payout_settings)){
                                                                        $payout_settings['email'] = "";
                                                                    }
                                                                   
                                                                    if(!array_key_exists('account_holder',$payout_settings)){
                                                                        $payout_settings['account_holder'] = "";
                                                                    }
																	// Address detail
                                                                    if(!array_key_exists('country',$payout_settings)){
                                                                        $payout_settings['country'] = "";
                                                                    }

                                                                    if(!array_key_exists('city',$payout_settings)){
                                                                        $payout_settings['city'] = "";
                                                                    }
                                                                    
                                                                    if(!array_key_exists('address',$payout_settings)){
                                                                        $payout_settings['address'] = "";
                                                                    }
																	
																	if(!array_key_exists('zipcode',$payout_settings)){
                                                                        $payout_settings['zipcode'] = "";
                                                                    }
																	
																	if(!array_key_exists('state',$payout_settings)){
                                                                        $payout_settings['state'] = "";
                                                                    }
																	// Bank detail
																	if(!array_key_exists('isfccode',$payout_settings)){
                                                                        $payout_settings['isfccode'] = "";
                                                                    }
																	
																	if(!array_key_exists('account_number',$payout_settings)){
                                                                        $payout_settings['account_number'] = "";
                                                                    }
                                                                @endphp
                                                                <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[email]" id="email" class="form-control" value="<?php echo $payout_settings['email']; ?>" placeholder="Email (Optional)">
                                                                </div>
																
                                                                <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[account_holder]" id="account_holder" class="form-control" value="<?php echo $payout_settings['account_holder']; ?>" placeholder="Account holder name" >
                                                                </div>
                                                                <div class="form-group toolip-wrapo">
																	<h6>Recipient's address:</h6>
																</div>
                                                                <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[country]" id="country" class="form-control" value="<?php echo $payout_settings['country']; ?>" placeholder="Country">
                                                                </div>
                                                                
                                                                <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[city]" id="city" class="form-control" placeholder="City" value="{{ $payout_settings['city'] }}">
                                                                </div>

																<div class="form-group toolip-wrapo">
                                                                    <textarea name="payout_settings[address]" id="address" class="form-control" placeholder="Address" rows="3">{{ $payout_settings['address'] }}</textarea>
                                                                </div>

                                                                <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[zipcode]" id="zipcode" class="form-control" placeholder="zipcode" value="{{ $payout_settings['zipcode'] }}">
                                                                </div>
																
																<div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[state]" id="state" class="form-control" placeholder="state" value="{{ $payout_settings['state'] }}">
                                                                </div>

                                                                <div class="form-group toolip-wrapo">
																	<h6>Bank details:</h6>
																</div>
																
																 <div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[isfccode]" id="isfccode" class="form-control" placeholder="ISFC Code" value="{{ $payout_settings['isfccode'] }}">
																	<span>(Notes: The Indian Financial System Code(ISFC) Identifies theIndian bank branch. It's 11 characters long and used for RTGS and NEFT transfars. You can finds your ISFC <a href="javascript:void(0)">here)</a></span>
                                                                </div>
																
																<div class="form-group toolip-wrapo">
                                                                    <input type="text" name="payout_settings[account_number]" id="account_number" class="form-control" placeholder="Account number" value="{{ $payout_settings['account_number'] }}">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </fieldset>
                                                @endif
                                            @endforeach
                                        @endif
                                        <fieldset>
                                            <div class="form-group wt-btnarea">
                                                <button type="submit" class="wt-btn wt-payrols-settings" data-id="<?php echo $payrol['id']; ?>">Confirm</button>
                                            </div>
                                        </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
