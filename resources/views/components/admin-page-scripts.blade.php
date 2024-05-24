@vite(['resources/js/app.js'])

<script>
    function listen() {
        window.Echo.private('App.Models.User.' + {{ \Illuminate\Support\Facades\Auth::user()->id }})
            .listen("TestBroadcastEvent", (event) => {
                console.log(event)
            })
            .notification((notification) => {
                console.log(notification)
            })

    }
</script>
