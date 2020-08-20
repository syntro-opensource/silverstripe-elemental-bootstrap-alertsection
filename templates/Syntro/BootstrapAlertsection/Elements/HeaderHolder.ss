<div class="mb-2 d-flex align-items-center justify-content-center text-left">
    <% if $FAIcon && useIcons %>
    <span class="mr-3 mr-md-2" style="font-size:1.5em;"><i class="$FAIcon"></i></span>
    <% end_if %>
    <% if ShowTitle %>
        <b>$Title:</b>
    <% end_if %>
</div>
