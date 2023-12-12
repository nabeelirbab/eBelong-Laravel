{!! App\EmailHelper::getEmailHeader() !!}

<p>Hello {{ $user['first_name']}},</p>


@foreach ($data as $item)
    
<table cellspacing="0" cellpadding="0" style="border: 1px solid #76767614;border-spacing: 0; border-collapse: collapse; width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 4px; margin-bottom: 12px; box-shadow: 0px 4px 13px rgba(0, 0, 0, 0.15);">
    <tr>
        <td style="padding: 20px;">
            <div style="float: left; color: #767676;">{{$item['employer']['first_name']}}</div>

            <div style="float: right; color: #3A0B5F; font-weight: 600; font-size: 16px; padding: 3px;">
                @if($item['project_type'] == 'fixed')
                ${{$item['price']}}
                @else 
                ${{$item['price']}}/hr 
                @endif
            </div>

            <br>

            <div style="margin-top: 15px;">
                <h2 style="margin-bottom: 0px;">
                    <a href="{{url('job/'.$item['slug'])}}" style="color: #0f0f0f; font-weight: 400; font-size: 18px; line-height: 22px; font-style: normal; text-transform: capitalize; font-family: 'Poppins', Arial, Helvetica, sans-serif; text-decoration: none;">{{ $item['title']}}</a>
                </h2>
            </div>

            <br>

            <div>
                <p style="color: #767676;">{!! \Illuminate\Support\Str::limit($item['description'], 1000) !!}</p>

            </div>

            <br>

            <div style="float: right !important">
                <a href="{{url('job/'.$item['slug'])}}" style="padding: 0.6rem 4rem; font-size: 1rem; font-weight: 600; border-radius: 4px; text-align: center; background: #9013F3; color: #fff; text-decoration: none; display: inline-block;">View Job</a>
            </div>
        </td>
    </tr>
</table>
@endforeach

{!! App\EmailHelper::getSignature() !!}
{!! App\EmailHelper::getEmailFooter() !!}
