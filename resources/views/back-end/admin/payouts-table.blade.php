<table class="wt-tablecategories" style="font-family:'Poppins', Arial, Helvetica, sans-serif; background-size:2px;background-size: 100% 2px; background-repeat: no-repeat;border: 1px solid #eee;">
    <thead>
        <tr style="background: #fcfcfc;">
            <th style="font-weight: 500;color: #323232;font-size: 15px;line-height: 20px;text-align: left;padding: 15px 20px;">{{ trans('lang.user_name') }}</th>
            <th style="font-weight: 500;color: #323232;font-size: 15px;line-height: 20px;text-align: left;padding: 15px 20px;">{{ trans('lang.amount') }}</th>
            <th style="font-weight: 500;color: #323232;font-size: 15px;line-height: 20px;text-align: left;padding: 15px 20px;">{{ trans('lang.payment_method') }}</th>
            <th style="font-weight: 500;color: #323232;font-size: 15px;line-height: 20px;text-align: left;padding: 15px 20px;">{{ trans('lang.processing_date') }}</th>
            <th style="font-weight: 500;color: #323232;font-size: 15px;line-height: 20px;text-align: left;padding: 15px 20px;">{{ trans('lang.status') }}</th>
        </tr>
    </thead>
    @if ($payouts->count() > 0)
        <tbody id="payout-table">
            @foreach ($payouts as $key => $payout)
                <tr id="{{$payout->id}}">
                    <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">{{ Helper::getUserName($payout->user_id) }}</td>
                    <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">
                        {{ Helper::currencyList($payout->currency)['symbol'] }}{{{ $payout->amount }}}
                    </td>
                    <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">
                        @if(!empty(Helper::getPayoutsList()[$payout->payment_method]['title']) && Helper::getPayoutsList()[$payout->payment_method]['title'] == "Direct Bank Transfer")
							<a class="payout-info" href="javascript:void(0);" rel="{{ json_encode($payout->paymentinfo) }}"> >{{!empty(Helper::getPayoutsList()[$payout->payment_method]['title']) ? Helper::getPayoutsList()[$payout->payment_method]['title'] : ''}}</a>
						@else
							{{!empty(Helper::getPayoutsList()[$payout->payment_method]['title']) ? Helper::getPayoutsList()[$payout->payment_method]['title'] : ''}}
						@endif
                    </td>
                    <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">{{{ \Carbon\Carbon::parse($payout->created_at)->format('M d, Y') }}}</td>
                    {{-- <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">{{{ $payout->status }}}</td> --}}
                    <td style="border-top: 1px solid #eff2f5;color: #767676;font-size: 13px;line-height: 20px;padding: 10px 20px;text-align: left;">
                        <span class="bt-content">
                            <form class="wt-formtheme wt-formsearch change-payout-status" id="change_job_status">
                                <fieldset>
                                    <div class="form-group">
                                        <span class="wt-select">
                                            <select id="{{$payout->id}}-payout_status" {{$payout->status == 'IN_PROCESS' ? 'style=pointer-events:none;' : ''}}>
                                                <option value="pending" {{$payout->status == 'pending' ? 'selected' : ''}}>{{ trans('lang.pending') }}</option>
                                                <option value="completed" {{$payout->status == 'completed' ? 'selected' : ''}}>{{ trans('lang.completed') }}</option>
                                                @if($payout->status == 'IN_PROCESS')
                                                <option value="in_process" {{$payout->status == 'IN_PROCESS' ? 'selected' : ''}}>{{ trans('lang.in_process') }}</option>
                                                @endif
                                            </select>
                                        </span>
                                        <?php if($payout->status == 'pending') { ?>
                                        <a href="javascrip:void(0);" class="wt-searchgbtn" @click.prevent='changePayoutStatus({{$payout->id}}, {{json_encode($payout->projects_ids)}})'><i class="fa fa-check"></i></a>
                                        <?php } ?>
                                    </div>
                                </fieldset>
                            </form>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endif
</table>



<!-- Modal -->
<div class="modal" id="paymentInfo" role="dialog">
	<div class="modal-dialog modal-lg">
	 <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Payment Information</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body"> 
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<span>Email:</span>&nbsp;
					<span class="payout-email"></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<span>Account Holder:</span>&nbsp;
					<span class="payout-account-holder"></span>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="form-group">
					<h6 class="title">Recipient's Address:</h6>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<span>Country:</span>&nbsp;
					<span class="payout-country"></span>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<span>City:</span>&nbsp;
					<span class="payout-city"></span>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<span>Address:</span>&nbsp;
					<span class="payout-address"></span>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<span>ZipCode:</span>&nbsp;
					<span class="payout-zipcode"></span>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<span>State:</span>&nbsp;
					<span class="payout-state"></span>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="form-group">
					<h6 class="title">Bank Details:</h6>
				</div>
			</div>
			<hr/>
			<div class="col-md-12">
				<div class="form-group">
					<span>ISFC Code:</span>&nbsp;
					<span class="payout-isfccode"></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<span>Account No:</span>&nbsp;
					<span class="payout-account-no"></span>
				</div>
			</div>
		</div> 
		</div> 
	  </div>
	</div>
</div>