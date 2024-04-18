@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'MOTORGAS COMPANY')   
    <img  src="https://motorgasperu.com/images/logo.png" width="150" height="70"  alt="Logo Motorgas" />    
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
