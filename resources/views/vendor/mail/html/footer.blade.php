<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
    {!!  nl2br(\Statamic\Globals\GlobalSet::findByHandle('company')->inCurrentSite()->get('mail_footer')) !!}
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
