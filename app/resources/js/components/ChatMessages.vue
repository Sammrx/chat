<template>
    <ul class="chat">
        <li class="left clearfix" v-for="message in messages" :key="message.id">
            <div v-if="message.user.id === user.id" class="clearfix message-left">
                <div class="header">
                    <strong>
                        {{ message.user.name[0] }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
            <div v-else class="clearfix message-right">
                <div class="header">
                    <strong>
                        {{ message.user.name[0] }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    props: ["messages", "user"],
};
</script>
