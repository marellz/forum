<template lang="html">
  <li class="notification-trigger">
    <a class="icon ion-md-notifications-outline" :class="{'has-notifications': unread.length}" @click = "active = !active" :data-notifications="unread.length"></a>
    <div class="notifications container" :class="{'active':active}">
      <div class="container-header">
        <h1 class="typ s title">Notifications</h1>
        <div class="container-header-actions">
          <a class="txt icon ion-md-close-circle" @click = "active = false"></a>
        </div>
      </div>
      <div class="container-content">
        <!-- notifications -->
        <div class="notification-wrap" v-if="notifications.length" >
          <a class="notification"
            :class="{'read':notification.read}"
            :href="'/notifications/action/'+notification.code"
            v-for="(notification,index) in unread">
            <span class="typ n content" v-html="notification.content"></span>
            <span class="typ xs it time">{{notification.timing}}</span>
          </a>
          <div>
            <div class="pd-xs older">
              <h1 class="typ s thick uc">Older</h1>
            </div>
            <a
            class="notification read"
            :href="'/notifications/action/'+notification.code"
            v-for="(notification,index) in read"
            >
              <span class="typ n content" v-html="notification.content"></span>
              <span class="typ xs it time">{{notification.timing}}</span>
            </a>
          </div>
        </div>

        <!-- no notifications-->
        <div class="align no-notifications" v-else>
          <h1 class="typ c s">No new notifications</h1>
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
