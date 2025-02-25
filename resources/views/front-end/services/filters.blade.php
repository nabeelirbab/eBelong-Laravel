<aside id="wt-sidebar" class="wt-sidebar">
    {!! Form::open(['url' => url('search-results'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch wt-formbackground']) !!}
        <input type="hidden" value="{{$type}}" name="type">
        <!-- <div class="wt-widget wt-effectiveholder wt-startsearch" style="padding-bottom: 0px; margin: 0px; ">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.start_search') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                 <span><i class="fas fa-th"></i></span>
                <span><i class="fas fa-list"></i></span>
            </div>
        </div> -->
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.cats') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_cat') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($categories))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($categories as $category)
                                @php $checked = ( !empty($_GET['category']) && in_array($category->slug, $_GET['category'] )) ? 'checked' : ''; @endphp
                                <span class="wt-checkbox">
                                    <input id="cat-{{{ $category->slug }}}" type="checkbox" name="category[]" value="{{{ $category->slug }}}" {{$checked}} >
                                    <label for="cat-{{{ $category->slug }}}"> <a href="{{ url('services/'.$category->slug) }}"  >{{{ $category->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.skills') }}</h2>
            </div>
        <fieldset>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_skills') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
            @if (!empty($skills))
           
                <div class="wt-checkboxholder wt-verticalscrollbar">
                    @foreach ($skills as $skill)
                        @php $checked = ( !empty($_GET['skill']) && in_array($skill->slug, $_GET['skill'] )) ? 'checked' : ''; @endphp
                        <span class="wt-checkbox">
                            <input id="skill-{{{ $skill->slug }}}" type="checkbox" name="skill[]" value="{{{ $skill->slug }}}" {{$checked}} >
                            <label for="skill-{{{ $skill->slug }}}"> <a href="{{ url('services/'.$skill->slug) }}"  >{{{ $skill->title }}}</a></label>
                        </span>
                    @endforeach
                </div>
            @endif
            </div>
        </fieldset>
    </div>

        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.locations') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_locations') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($locations))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($locations as $location)
                                @php $checked = ( !empty($_GET['locations']) && in_array($location->slug, $_GET['locations'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="location-{{{ $location->slug }}}" type="checkbox" name="locations[]" value="{{{$location->slug}}}" {{$checked}} >
                                    <label for="location-{{{ $location->slug }}}">
                                        <a href="{{ url('services/'.$location->slug) }}" class="anchor-content-center" > 
                                            <div><img src="{{{asset(Helper::getLocationFlag($location->flag))}}}" alt="{{ trans('lang.img') }}" style="width:25px;height:18px"></div> 
                                            <div  class="location-name">{{{ $location->title }}} </div> 
                                        </a>
                                    </label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.langs') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_langs') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($languages))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($languages as $language)
                                @php $checked = ( !empty($_GET['languages']) && in_array($language->slug, $_GET['languages'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="language-{{{ $language->slug }}}" type="checkbox" name="languages[]" value="{{{$language->slug}}}" {{$checked}} >
                                    <label for="language-{{{ $language->slug }}}"><a href="{{ url('services/'.$language->slug) }}"  >{{{ $language->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.delivery_time') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_delivery_time') }}" >
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($delivery_time))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($delivery_time as $time)
                                @php $checked = ( !empty($_GET['delivery_time']) && in_array($time->slug, $_GET['delivery_time'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="time-{{{ $time->slug }}}" type="checkbox" name="delivery_time[]" value="{{{$time->slug}}}" {{$checked}} >
                                    <label for="time-{{{ $time->slug }}}"><a href="{{ url('services/'.$time->slug) }}"  >{{{ $time->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.response_time') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_response_time') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($response_time))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($response_time as $time)
                                @php $checked = ( !empty($_GET['response_time']) && in_array($time->slug, $_GET['response_time'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="time-{{{ $time->slug }}}" type="checkbox" name="response_time[]" value="{{{$time->slug}}}" {{$checked}} >
                                    <label for="time-{{{ $time->slug }}}"><a href="{{ url('services/'.$time->slug) }}"  >{{{ $time->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgetcontent">
                <div class="wt-applyfilters">
                    <span>{{ trans('lang.apply_filter') }}<br> {{ trans('lang.changes_by_you') }}</span>
                    {!! Form::submit(trans('lang.btn_apply_filters'), ['class' => 'wt-btn']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</aside>
