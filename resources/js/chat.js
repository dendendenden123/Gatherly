const chatBox = document.getElementById("chat-box");
const messageInput = document.getElementById("message");
const sendButton = document.getElementById("send");
const typingIndicator = document.getElementById("typing");

// Function to add message to chat
function addMessage(message, isUser = false) {
    const msgClass = isUser ? "user" : "bot";
    const sender = isUser ? "You" : "AI";

    const msgElement = document.createElement("div");
    msgElement.className = `msg ${msgClass}`;
    msgElement.innerHTML = `${message}`;

    chatBox.appendChild(msgElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Function to simulate typing
function showTyping() {
    typingIndicator.style.display = "block";
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Function to hide typing
function hideTyping() {
    typingIndicator.style.display = "none";
}

// Send message function
async function sendMessage() {
    const msg = messageInput.value.trim();
    if (!msg) return;

    // Add user message to chat
    addMessage(msg, true);
    messageInput.value = "";

    // Show typing indicator
    showTyping();

    try {
        // Simulate API call delay
        setTimeout(async () => {
            //  In a real implementation, you would use the actual API
            const res = await fetch("/admin/chat/store", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ message: msg }),
            });

            const data = await res.json();
            const replies = data.reply;

            console.log(data);
            const reply = replies;

            // Hide typing indicator and add bot response
            hideTyping();
            addMessage(reply, false);
        }, 1500);
    } catch (error) {
        hideTyping();
        addMessage("Sorry, I encountered an error. Please try again.", false);
        console.error("Error:", error);
    }
}

// Event listeners
sendButton.addEventListener("click", sendMessage);

messageInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        sendMessage();
    }
});

// Focus on input when page loads
messageInput.focus();
