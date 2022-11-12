<template>
    <div class="input-group">
        <input
            id="btn-input"
            type="text"
            name="message"
            class="form-control"
            placeholder="Write your message..."
            v-model="newMessage"
        @keyup.enter="sendMessage"
        />
        <span class="input-group-btn second-button">
          <button id="btn-chat" @click="sendMessage">
            <img src="img/vector.png">
          </button>
        </span>
    </div>
</template>
<script>
export default {
    props: ["user"],
    data() {
        return {
            newMessage: "",
        };
    },
    methods: {
        sendMessage() {
            this.$emit("messagesent", {
                user: this.user,
                message: this.newMessage,
            });
            this.newMessage = "";
        },
    },
};
</script>
