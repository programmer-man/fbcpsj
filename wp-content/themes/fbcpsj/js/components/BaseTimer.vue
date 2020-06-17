<template>
  <div>

    <div v-if="timeLeft < timeLimit">
       <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <g class="base-timer__circle">
          <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45" />
          <path
            :stroke-dasharray="circleDasharray"
            class="base-timer__path-remaining"
            d="
                M 50, 50
                m -45, 0
                a 45,45 0 1,0 90,0
                a 45,45 0 1,0 -90,0
            "
          />
        </g>
      </svg>
      <span class="base-timer__label">
        <span class="days-left" v-html="days"></span>
        <span class="time-left" v-html="time"></span>
      </span>
    </div>

    <div v-else class="base-timer" >
      <slot></slot> 
    </div>

  </div>
</template>
<script>
// A value we had to play with a bit to get right
const FULL_DASH_ARRAY = 2150;
// When the timer should change from green to orange
const WARNING_THRESHOLD = 10;
// When the timer should change from orange to red
const ALERT_THRESHOLD = 5;

import moment from "moment";

export default {
  props: {
    messageDate: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      timerInterval: null,
      timeLeft: 604800,
      timeLimit: 604800,
      timePassed: 0,
      time: null,
      days: null
    };
  },

  computed: {
    // Update the dasharray value as time passes, starting with 283
    circleDasharray() {
      return `${this.timeFraction * (this.timeLimit / FULL_DASH_ARRAY)} ${(this.timeLimit / FULL_DASH_ARRAY)}`;
    },
    timeFraction() {
      // Divides time left by the defined time limit.
      return this.timeLeft / this.timeLimit;
    }
  },

  mounted() {
    this.startTimer();
    console.log(
      "message starts: " +
        moment(this.messageDate).format("dddd, MMMM Do YYYY, h:mm:ss a")
    );
    console.log(
      "now: " + moment(new Date()).format("dddd, MMMM Do YYYY, h:mm:ss a")
    );

    // this.timeLeft = moment(new Date()).format('SSSSSSSSS')
  },

  methods: {
    startTimer() {
      this.timerInterval = setInterval(() => this.updateTime(), 1000);
    },

    updateTime() {
      var now = moment(new Date());
      var end = moment(this.messageDate);
      var ms = moment.duration(end.diff(now));

      console.log(ms)

      this.days =
        ms._data.days > 0
          ? ms._data.days.toString().replace("-", "") + " Days"
          : "starting in...";

      this.time =
        (ms._data.hours < 10 ? "0" + ms._data.hours : ms._data.hours)
          .toString() + ":" +
        (ms._data.minutes < 10 ? "0" + ms._data.minutes : ms._data.minutes)
          .toString() + ":" +
        (ms._data.seconds < 10 ? "0" + ms._data.seconds : ms._data.seconds)
          .toString()

        this.timeLeft = this.timeLimit - (
            ms._data.seconds + 
            (ms._data.minutes * 60) + 
            (ms._data.hours * 3600) + 
            (ms._data.days * 86400)
        )
    }
  }
};
</script>
<style scoped lang="scss">
/* Sets the containers height and width */
.base-timer {
  position: relative;
  width: 300px;
  height: 300px;
  margin: 0 auto 2rem;
  /* Removes SVG styling that would hide the time label */
  &__circle {
    fill: none;
    stroke: none;
  }
  /* The SVG path that displays the timer's progress */
  &__path-elapsed {
    stroke-width: 8px;
    stroke: white;
  }

  &__label {
    position: absolute;

    /* Size should match the parent container */
    width: 300px;
    height: 300px;
    /* Keep the label aligned to the top */
    top: 0;
    /* Create a flexible box that centers content vertically and horizontally */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    /* Sort of an arbitrary number; adjust to your liking */
    font-size: 48px;
    line-height: 1.1em;

    .days-left {
      font-size: 0.5em;
      margin-top: -5px;
    }
  }

  &__path-remaining {
    /* Just as thick as the original ring */
    stroke-width: 7px;
    /* Rounds the line endings to create a seamless circle */
    stroke-linecap: round;
    /* Makes sure the animation starts at the top of the circle */
    transform: rotate(90deg);
    transform-origin: center;
    /* One second aligns with the speed of the countdown timer */
    transition: 1s linear all;
    /* Allows the ring to change color when the color value updates */
    stroke: rgb(65, 184, 131); // green
  }
  &__svg {
    /* Flips the svg and makes the animation to move left-to-right */
    transform: scaleX(-1);
  }
}
</style>