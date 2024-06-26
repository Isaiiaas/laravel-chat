@extends('layouts')

@section('content')

<a href="{{ route('dashboard') }}">Go Back to To Dashboard</a>
<script>
    var roomId = {{ $roomId }};

    const scrollToBottom = (element) => element.scroll({ top: element.scrollHeight, behavior: 'smooth' });

    const updateMessages = (messages) => {
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML = '';

        for(let i = 0; i < messages.length; i++){
            const row = document.createElement("div");
            row.classList.add("row");

            const userInfo = document.createElement("small");
            userInfo.innerText = `${messages[i].user.name} | ${messages[i].time}`;

            const messageContent = document.createElement("div");
            messageContent.innerText = messages[i].text;

            row.appendChild(userInfo);
            row.appendChild(messageContent);
            messagesDiv.appendChild(row);
        }
        
        setTimeout(()=> scrollToBottom(messagesDiv), 100);
    }

    const getMessages = async () => {
        const apiFetchMessages = "{{ route('messageSend') }}";
        try {
            const response = await fetch(apiFetchMessages + "/" + roomId);
            const result = await response.json();
            updateMessages(result);
        } catch (error) {
            console.error("Error:", error);
        }
    }

    const sendMessage = async () => {
        const apiSendMessage = "{{ route('messageSend') }}";
        try {
            
            const formData = new FormData();
            const messageText = document.getElementById('text');
            const csftToken = document.getElementsByName('_token')[0];

            // Avoid sending empty messages.
            if(messageText.value == ""){
                return;
            }

            formData.append("room_id", roomId);
            formData.append("text", messageText.value);
            formData.append("_token", csftToken.value);
            
            messageText.value = "";

            const response = await fetch(apiSendMessage, {
                 cache: "no-cache", 
                credentials: "same-origin", 
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': csftToken.value
                },
                body: formData
            });
            const result = await response.json();

            //Update All the Messages
            getMessages()
        } catch (error) {
            console.error("Error:", error);
        }
        return false;
    }

    const connectWebSocket = () => {
        window.Echo.private(webSocketChannel)
            .listen('GotMessage', async (e) => {
                await getMessages();
            });
    }

    window.addEventListener("load", (event) => {
        getMessages();

        const roomWs = `room.${roomId}`;
        window.Echo.private(roomWs)
            .listen('GotMessage', async (e) => {
                await getMessages();
            });

    });
</script>
<style>#messages { max-height: 400px; overflow-y: auto; overflow-x: hidden} textarea{ width:100%} </style>

<div class="row justify-content-center align-items-center h-100">
    <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
    <h3>Room {{ $roomName }}</h3>
    <div id="messages" name="messages"></div>

    <form method="POST" action="" onsubmit="return false">
        @csrf
        <textarea name="text" id="text" rows="8" cols="32"></textarea>
        <button onclick="sendMessage()">Send Message</button>
    </form>
    </div>
</div>