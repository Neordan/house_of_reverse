</main>

<div class="btn-up">
    <a href="#top"><i class="fa-solid fa-chevron-up" style="color: #825857;"></i></a>

</div>
<footer>
    <div class="socials">
        <a href="https://instagram.com/house.of.reverse?igshid=YmMyMTA2M2Y=" class="insta">
            <i class="fa-brands fa-instagram"></i>
            <p>@house.of.reverse</p>
        </a>
        <a href="https://www.tiktok.com/@house.of.reverse?_t=8bib4zmnFtq&_r=1" class="tiktok">
            <i class="fa-brands fa-tiktok"></i>
            <p>@house.of.reverse</p>
        </a>
    </div>
    <div class="nav-down">
        <ul>
            <li><a href="../index.php">Accueil</a>
            </li>
            <li><a href="#">Politique de protection des données</a></li>
            <li><a href="#">Modalité de vente</a></li>
        </ul>
    </div>
    <div class="copy">
        <p>&copy Mélhian ADAM</p>
        <p>Propriété de House of Reverse</p>
    </div>
</footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initToggleDescription();
    });

    function onClick(e) {
        e.preventDefault();
        grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6LcdrEknAAAAAOGZX9njn_jn-1DqJWLzdGS8CEvF', {
                action: 'LOGIN'
            });
        });
    }
</script>

</html>