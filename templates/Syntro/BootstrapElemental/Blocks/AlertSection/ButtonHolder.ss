<p class="mb-0 mt-2">
    <% loop Buttons %>
        <% if LinkURL %>
            <a {$IDAttr} class="mx-1 btn btn-sm btn-outline-$Up.ComputedTextColor" href="{$LinkURL}"{$TargetAttr}>
                {$Title}
            </a>
        <% end_if %>
    <% end_loop %>
</p>
