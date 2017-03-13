   <script>
        if (screen.width >546 && screen.width < 768) {
        var mvp = document.getElementById('testViewport');
        mvp.setAttribute('content', 'width=320, maximum-scale=1.5,initial-scale=1.5');
        }

        if (screen.width >= 768) {
            var mvp = document.getElementById('testViewport');
            mvp.setAttribute('content', 'width=320, maximum-scale=2, initial-scale=2');
        }

</script>