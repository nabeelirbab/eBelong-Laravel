<p>Hello Admin,</p>

<p>The new request of Find Your Match to eBelong.</p>

<p>Details are give below:</p>
<ul>
    <li><strong>Full Name:</strong>  {{ $data['full_name'] }}</li>
    <li><strong>Email:</strong>  {{ $data['email'] }}</li>
    <li><strong>Phone Number:</strong>  {{ $data['phone_number'] }}</li>
    <li><strong>Positions:</strong>  {{ $data['positions'] }}</li>
    <li><strong>Collaborative:</strong>  {{ $data['collaborative'] }}</li>
    <li><strong>Agile Approach:</strong>  {{ $data['agile_approach'] }}</li>
    <li><strong>Creative:</strong>  {{ $data['creative'] }}</li>
    <li><strong>Follower:</strong>  {{ $data['follower'] }}</li>
    <li><strong>Initiator:</strong>  {{ $data['initiator'] }}</li>
    <li><strong>Instructions Follower:</strong>  {{ $data['instructions_follower'] }}</li>
    <li><strong>Product Focus:</strong>  {{ $data['product_focus'] }}</li>
    <li><strong>Project Focused:</strong>  {{ $data['project_focused'] }}</li>
    <li><strong>Silent Shy:</strong>  {{ $data['silent_shy'] }}</li>
    <li><strong>Structed Methodical:</strong>  {{ $data['structed_methodical'] }}</li>
    <li><strong>Vocal Blunt:</strong>  {{ $data['vocal_blunt'] }}</li>
    <li><strong>Waterfall Approach:</strong>  {{ $data['waterfall_approach'] }}</li>
    <li><strong>Selected Categories:</strong>  {{ $data['selected_categories'] }}</li>
    <li><strong>Selected Skills:</strong>  {{ $data['selected_skills'] }}</li>
    @if($data['selected_freelancers'])
    <li><h4>Hired Candidates</h4>

<table>
  <tr>
    <th>Candidate Name</th>
    <th>Hired Hours</th>
  </tr>
 
  @foreach ($data['selected_freelancers'] as $key=>$item)
  @php $user = \App\User::find($key);@endphp
  <tr>
    <td><a href="https://ebelong.com/profile/{{ $user->slug }}"> {{{  ucwords(\App\Helper::getUserName($key))  }}}</td>
  <td>{{ $item }}</td>
</tr>
    @endforeach

</table>
    </li>
    @endif
</ul>
