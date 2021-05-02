@if ( Request::segment(1) == "systemadmin" OR Request::segment(1) == "storeadmin" )

@else

<section id="bigfooter">
    <div class="container">
        <div class="information social-media-info">
            <h1>Social Media</h1>
                <p>   Arrogante, Louise David</p>
                <p>   Bascon, Kim</p>
                <p>   Casul, Wendell</p>
                <p>   Munez, Ernest Jacob</p>
        </div>
        <div class="information location-info">
            <h1>Location</h1>
                <br>
                <p>
                    Marigondon, Lapu - lapu City
                </p>
        </div>
        <div class="information contact us-info">
            <h1>Contact Us</h1>
                <br>
                <p>
                    Phone : 494-1901 or 514-2243
                </p>
                <p>
                     E-mail : casulwendell12@gmail.com
                </p>
        </div>
    </div>
</section>

@endif

<footer>
    <p>Quick Grocery, Copyright &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
