<template lang="html">
  <div class="container">
    <template v-if="!doesNotExist">
    <div class="container-header accent">
      <h1 class="typ title">{{thread.title}}</h1>
      <div class="container-header-actions">
        <a
        @click="likeThread(thread.code)"
        class="icon txt n"
        :class="thread.liked ? 'ion-md-heart' : 'ion-md-heart-empty'">
        <span class="txt">{{thread.likes}}</span>
        </a>
      </div>
    </div>

    <div class="container-body no-pd">
      <!-- primary reply -->
      <div class="section thread-component primary">
        <div class="thread-author">
          <span class="avatar" :style="'background-image:url('+thread.user.avatar+')'"></span>
        </div>
        <div class="thread-content">
          <div class="thread-content-header">
            <h3 class="typ thick">{{thread.user.name}}</h3>
            <span class="typ s it">{{thread.timing}}</span>
          </div>
          <div class="pd-xs-v">
            <p class="typ">
              {{thread.content}}
            </p>
          </div>
        </div>

      </div>

      <!-- other replies -->
      <div class="replies">
        <!-- if replies > 0 -->
        <h1 v-if="replies.length" class="icon ion-md-undo typ s">Replies</h1>
        <!-- else -->
        <h1 v-else class="typ s pd-xs c">No replies. Be the first to make one.</h1>
      </div>

      <!-- other replies -->
      <div v-for="(reply,index) in replies" class="section thread-component">
        <div class="thread-author">
          <span class="avatar" :style="'background-image:url('+reply.user.avatar+')'"></span>
        </div>
        <div class="thread-content">
          <div class="thread-content-header">
            <h3 class="typ thick">{{reply.user.name}}</h3>
            <span class="typ s it">{{reply.timing}}</span>
          </div>
          <div class="pd-xs-v">
            <p class="typ">
              {{reply.content}}
            </p>
          </div>
          <div class="thread-actions">
            <a :title="hasAuth ? 'Like this reply' : 'You must log in to like.' " @click="likeReply(reply.code,index)" class="icon typ" :class="reply.liked ? 'ion-md-heart active': 'ion-md-heart-empty'">{{reply.likes}} <span class="txt non-mobile-only">{{reply.likes == 1 ? 'like' :'likes'}}</span></a>
            <a v-if="reply.isOwner" @click="deleteReply(reply.code,index)" class="icon typ ion-md-trash"><span class="txt non-mobile-only">Delete</span></a>
          </div>
        </div>

      </div>

      <!-- reply form -->
      <div class="section thread-reply" v-if="hasAuth">
        <div class="pd-xs">
        </div>
        <form  method="post" @submit.prevent="saveReply">
          <div class="input textarea">
            <textarea required v-model="reply" placeholder="Write your reply here"></textarea>
          </div>
          <div class="">
            <button>Reply</button>
          </div>
        </form>
      </div>
      <div class="section thread-reply no-auth" v-else>
        <div class="pd">
          <h2 class="typ thin c">You must be <a href="/login" class="txt ul">signed in</a> to reply.</h2>
        </div>
      </div>
    </div>
    </template>
    <template v-else>
      <div class="pd-l">
        <h1 class="typ thin">We have a problem.</h1>
        <p class="typ">
          This thread does not exist.
        </p>
      </div>
    </template>
  </div>

</template>

<script>
export default {
  name:'ThreadView',
  props:['auth','code'],
  data(){
    return {
      doesNotExist: false,
      thread: {
        user:{},
      },
      replies:[],
      reply:'',

    }
  },
  computed:{
    hasAuth(){
      return this.auth;
    },
    canReply(){
      return this.replies.length < 1 && this.thread.isOwner
    }
  },
  methods:{
    likeThread(code){
      if(!this.hasAuth){
        return false;
      }
      axios.post('/like/'+code)
      .then(function(res) {
        this.thread.liked = res.data.liked
        res.data.liked ? ++this.thread.likes : --this.thread.likes
      }.bind(this)).catch(function(err) {
        console.error(err)
      })
    },
    likeReply(code,index){
      if(!this.hasAuth){
        return false;
      }
      axios.post('/like/'+code)
      .then(function(res) {
        this.replies[index].liked = res.data.liked
        res.data.liked ? ++this.replies[index].likes : --this.replies[index].likes
      }.bind(this)).catch(function(err) {
        console.error(err)
      })
    },
    deleteReply(code,index){
      axios.post('/delete-reply/'+code)
      .then(function(res) {
        if(res.data.deleted){
          this.replies.splice(index,1)
        }
      }.bind(this)).catch(function(err) {
        console.error(err)
      })
    },
    saveReply(){
      console.log('saving');
      axios.post(
        '/thread/view/'+this.code+'/comment',
      {reply:this.reply})
      .then(function(res) {
        if(res.data.success){
          this.replies.unshift(res.data.reply)
          this.reply=''
        }
      }.bind(this))
      .catch(function (err) {
        console.error(err)
      })
    }
  },
  mounted(){
    //get thread
    axios.get('/thread/fetch/'+this.code)
    .then(function (res) {
      if(res.data.error){
        this.doesNotExist = true
        return false
      }
      if(res.data.thread.id){
        this.thread = res.data.thread
        this.replies = res.data.replies
      }
    }.bind(this))
    .catch(function (err) {
      console.error(err)
    })

  }
}
</script>

<style lang="css">
</style>
