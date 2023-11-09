@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="coupons-listing" id="coupon-list">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="wt-haslayout wt-dbsectionspace la-addnewcoupons">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                    <div class="wt-dashboardbox la-coupon-box">
                        <div class="wt-dashboardboxtitle">
                            <h2>Add New Coupon</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open([
                                'url' => url('admin/coupons'),
                                'class' =>'wt-formtheme wt-formprojectinfo wt-formcoupon', 'id'=> 'coupons'
                                ])
                            !!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text('code', null, ['class' =>'form-control'.($errors->has('code') ? ' is-invalid' : ''), 'placeholder' => 'Coupon Code']) !!}
                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::select('type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], null, ['placeholder' => 'Select Discount Type', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::number('value', null, ['class' => 'form-control', 'placeholder' => 'Discount Value']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::date('expires_at', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        {!! Form::submit('Add Coupon', ['class' => 'wt-btn']) !!}
                                    </div>
                                </fieldset>
                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-right">
                    <div class="wt-dashboardbox">
                        {{-- <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2>Coupons</h2>
                            {!! Form::open(['url' => url('admin/coupons/search'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']) !!}
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}"
                                        class="form-control" placeholder="{{{ trans('lang.ph_search_coupons') }}}">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                            {!! Form::close() !!}
                        </div> --}}
                        @if ($coupons->count() > 0)
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories" id="checked-val">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Expires At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($coupons as $coupon)
                                            <tr class="del-{{{ $coupon->id }}}">
                                                <td>{{{ $coupon->code }}}</td>
                                                <td>{{{ $coupon->type }}}</td>
                                                <td>{{{ $coupon->value }}}</td>
                                                <td>{{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'N/A' }}}</td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="{{ url('admin/coupons/' . $coupon->id . '/edit') }}" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <a href="{{ url('admin/coupons/' . $coupon->id) }}" class="wt-deleteinfo wt-skillsaddinfo" onclick="return confirm('{{{ trans('lang.ph_delete_confirm_title') }}}')">
                                                            <i class="lnr lnr-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ( method_exists($coupons,'links') )
                                    {{ $coupons->links('pagination.custom') }}
                                @endif
                            </div>
                        @else
                            @include('errors.no-record', ['message' => 'No coupons found'])
                        @endif
                    </div>
                </div>
                
                
            </div>
        </section>
    </div>
@endsection
