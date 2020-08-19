<section class="bg-$BackgroundColor text-$TextColor py-4">
    <div class="container text-center">
        <% if FAIcon && useIcons || ShowTitle %>
            <p class="mb-2">
                <% if $FAIcon && useIcons %>
                <span class="mr-2"><i class="$FAIcon"></i></span>
                <% end_if %>
                <% if ShowTitle %>
                    <b>$Title:</b>
                <% end_if %>
            </p>
        <% end_if %>
        <p class="m-0 text-justify text-md-center">
            $Content
        </p>
        <% if $Buttons %>
            <p class="mb-0 mt-2">
                <% loop Buttons %>
                    <% if LinkURL %>
                        <a {$IDAttr} class="mx-1 btn btn-sm btn-outline-$Up.TextColor" href="{$LinkURL}"{$TargetAttr}>
                            {$Title}
                        </a>
                    <% end_if %>
                <% end_loop %>
            </p>
        <% end_if %>
    </div>
</section>
