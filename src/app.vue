<script setup>
    import { get } from './helpers.js'
    import { ref } from 'vue'
    import { onMounted } from 'vue'

    let gettingauthlink = ref(false) // loading indicator
    let screen_name = ref('') // name of the user inside button

    onMounted(() => {
        twitterAuthorizeCallback()
        getSignedInUserName()
    })

    function getSignedInUserName()
    {
        get('http://localhost:8000/backend/', {
            action: 'getsignedinusername',
        }, (data) => {
            if (data.screen_name) screen_name.value = data.screen_name;
        })
    }

    function twitterAuthorizeCallback()
    {
        let params = new URLSearchParams(location.search)
        if (params.has('denied')) window.history.replaceState({}, document.title, '/')
        if (!params.has('oauth_token') || !params.has('oauth_verifier')) return

        get('http://localhost:8000/backend/', {
            action: 'authorize',
            oauth_token: params.get('oauth_token'),
            oauth_verifier: params.get('oauth_verifier'),
        }, () => {
            window.history.replaceState({}, document.title, '/') // clean get parameters from query sting
        })
    }

    function getTwitterAuthLink()
    {
        gettingauthlink.value = true

        get('http://localhost:8000/backend/', {
            action: 'gettwitterauthlink',
        }, (data) => {
            if (data.url) {
                screen_name.value = ''
                window.location = data.url
            }
            gettingauthlink.value = false
        })
    }
</script>

<template>
    <p :class="{'loading-btn': gettingauthlink, 'box-btn': true}"
       title="Sign in with Twitter"
       @click="getTwitterAuthLink"
    >
        <!-- Sign in -->
        <svg v-if="!gettingauthlink && !screen_name" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
        </svg>

        <!-- Sign out -->
        <svg v-if="!gettingauthlink && screen_name" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>

        <!-- Loading -->
        <span v-if="gettingauthlink">⌚︎</span>

        <span v-if="!gettingauthlink && screen_name">&nbsp;{{ screen_name }}&nbsp;</span>
    </p>
</template>


<style>
</style>
