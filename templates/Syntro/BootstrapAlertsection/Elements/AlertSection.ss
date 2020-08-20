<section class="bg-$BackgroundColor text-$TextColor py-4">
    <div class="container text-center">
        <% if FAIcon && useIcons || ShowTitle %>
            $HeaderHolder
        <% end_if %>
        $ContentHolder
        <% if $Buttons %>
            $ButtonHolder
        <% end_if %>
    </div>
</section>
