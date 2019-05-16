<template>
  <span id="countdown-to-start" class="course-details__countdown">
    {{ days }}d {{ hours }}h {{ minutes }}min
  </span>
</template>

<script>
export default {
  mounted: function() {
    window.setInterval(() => {
      this.now = Math.trunc((new Date()).getTime() / 1000);
    },1000);
  },
  props: {
    date: String,
  },
  data: function() {
    return {
      now: Math.trunc((new Date()).getTime() / 1000)
    }
  },
  computed: {
    normalizedDate: function() {
      return Math.trunc(Date.parse(this.date) / 1000)
    },
    seconds: function() {
      return (this.normalizedDate - this.now) % 60
    },
    minutes: function() {
      return Math.trunc((this.normalizedDate - this.now) / 60) % 60
    },
    hours: function() {
      return Math.trunc((this.normalizedDate - this.now) / 60 / 60) % 24
    },
    days: function() {
      return Math.trunc((this.normalizedDate - this.now) / 60 / 60 / 24)
    },
  },
  filters: {
    twoDigits: function(value) {
      if (value.toString().length <= 1) {
        return "0" + value.toString();
      }
      return value.toString();
    }
  }
}
</script>
