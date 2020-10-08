<section class="bg-$BackgroundColor text-$TextColor py-4">
    <div class="container text-center">
        <% if DisplayIcon && useIcons || ShowTitle %>
            <div class="mb-2 d-flex align-items-center justify-content-center text-left">
                <% if DisplayIcon && useIcons %>
                    <span class="mr-3 mr-md-2" style="font-size:1.5em;">
                        <i class="$FAIcon"></i>
                    </span>
                <% end_if %>
                <% if ShowTitle %>
                    <b>$Title</b>
                <% end_if %>
            </div>
        <% end_if %>
        <p class="m-0 text-justify text-md-center">
            $Content
        </p>
        <% if $Buttons %>
            <p class="mb-0 mt-2">
                <% loop Buttons %>
                    <% if LinkURL %>
                        <a {$IDAttr} class="mx-1 btn btn-sm btn-outline-$Up.LinkColor" href="{$LinkURL}"{$TargetAttr}>
                            {$Title}
                        </a>
                    <% end_if %>
                <% end_loop %>
            </p>
        <% end_if %>
    </div>
</section>
