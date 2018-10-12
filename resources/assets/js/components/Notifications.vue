<template lang="html">
  <li class="notification-trigger">
    <a class="icon ion-md-notifications-outline" :class="{'has-notifications': unread.length}" @click = "active = !active" :data-notifications="unread.length"></a>
    <div class="notifications-wrap" :class="{'is-active':active}">
      <div class="notifications">
        <div class="notifs-head">
          <i class="icon close ion-md-arrow-forward" @click="active = false"></i>
          <h1 class="typ n">Notifications</h1>
        </div>
        <div class="notifs-content">
          <!-- notifications -->
          <div class="notification-wrap" v-if="notifications.length" >
            <a class="notification"
            :class="{'read':notification.read}"
            :href="'/notifications/action/'+notification.code"
            v-for="(notification,index) in unread">
            <span class="typ n content" v-html="notification.content"></span>
            <span class="typ xs it time">{{notification.timing}}</span>
          </a>
          <div v-if="read.length">
            <div class="pd-xs older">
              <h1 class="typ s thick uc">Older</h1>
            </div>
            <div
            class="notification read"
            v-for="(notification,index) in read"
            :key="index">
            <a :href="'/notifications/action/'+notification.code">
              <span class="typ n content" v-html="notification.content"></span>
              <span class="typ xs it time">{{notification.timing}}</span>
            </a>
            <a class="icon delete ion-md-trash" @click="deleteNotification(notification.code)"></a>
          </div>
        </div>
      </div>

      <!-- no notifications-->
      <div class="align no-notifications pd-v" v-else>
        <h1 class="typ c icon ion-md-done-all">No notifications</h1>
      </div>
    </div>
  </div>
</div>
</div>
</li>
</template>

<script>
export default {
  name: 'Notifications',
  data(){
    return {
      active: false,
      notifications:[],
    }
  },
  computed:{
    unread(){
      return this.notifications.filter(function(notif){
        return !notif.read
      })
    },
    read(){
      return this.notifications.filter(function(notif){
        return notif.read
      })
    }
  },
  methods:{
    deleteNotification(code){
      axios.post('/notifications/action/'+code+'/delete')
      .then(function(res){
        if(res.data.success){
          this.notifications.splice(
            this.notifications.findIndex(function(notif){
              notif.code == code
            }.bind(this)),1)
        }
      }.bind(this))
      .catch(function (err) {
        console.error(err)
      })
    },

    fetchNotifications(){
      axios.get('/notifications/fetch')
      .then(function(res) {
        if(res.data.success){
          this.notifications = res.data.notifications
        }
      }.bind(this))
      .catch(function (err) {
        console.error(err)
      })
    }
  },
  mounted(){
    this.fetchNotifications()
    setInterval(this.fetchNotifications,60000)
  }
}
</script>
