<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <div class="mt-10 mb-20">
      <div class="mb-4" v-if="editMode">
        <h2 class="text-xl font-semibold text-red-200">
          {{ venue.name }}
        </h2>
        <div
          class="
            p-2
            text-sm
            my-5
            bg-white
            font-bold
            border-2
            rounded-xl
            border-red-500
            text-red-500 text-center
          "
          v-if="live && !user.verified"
        >
          Your account is not verified by GoFish. We will send you an email once
          your account has been verified.
        </div>
        <div
          class="
            p-2
            text-sm
            my-5
            bg-white
            font-bold
            border-2
            rounded-xl
            border-warning
            text-warning text-center
          "
          v-if="live && user.verified && !venue.subscription.confirmed"
        >
          <a href="#" v-on:click="subscriptionTab($event)"
            >You do not have an active subscription with GoFish. Your venue may
            not be visible on our website.</a
          >.
        </div>
      </div>
      <div v-if="user.verified">
        <div class="mb-4 md:col-span-2 md:mb-0">
          <manage-tabs-component
            :isGlobalAdmin="user.globalAdmin"
            :active="venueManageTab"
            :manageVenueErrorFields="manageVenueErrorFields"
            @setTab="setTab"
          ></manage-tabs-component>
        </div>

        <manage-details-component
          v-if="venueManageTab === manageTabs.DETAILS"
          :loading="loading"
          :venue="venue"
          :manageVenueErrorFields="manageVenueErrorFields"
          @deleteImage="deleteImage"
          @uploadImage="uploadImage"
        ></manage-details-component>
        <manage-opening-hours-component
          v-if="venueManageTab === manageTabs.HOURS"
          :venue="venue"
          :closed="venueManageClosed"
          :loading="loading"
          @start="venueClosedStart"
          @end="venueClosedEnd"
          @add="venueClosedAdd"
          @delete="venueClosedDelete"
        ></manage-opening-hours-component>
        <manage-payment-component
          v-if="venueManageTab === manageTabs.PAYMENT"
          :loading="loading"
          :venue="venue"
          :manageVenueErrorFields="manageVenueErrorFields"
          :admin="user.globalAdmin"
          @create="accountCreate"
        ></manage-payment-component>
        <manage-location-component
          v-if="venueManageTab === manageTabs.LOCATION"
          :loading="loading"
          :venue="venue"
          :venueSearch="venueSearch"
          :manageVenueErrorFields="manageVenueErrorFields"
        ></manage-location-component>
        <manage-tickets-component
          v-if="venueManageTab === manageTabs.TICKETS"
          :loading="loading"
          :venue="venue"
          :editMode="editMode"
          :manageVenueNewTicket="manageVenueNewTicket"
          :manageVenueErrorFields="manageVenueErrorFields"
          @addNewTicket="addNewTicket"
          @saveTicket="saveTicket"
          @deleteTicket="deleteTicket"
        ></manage-tickets-component>
        <manage-subscription-component
          v-if="venueManageTab === manageTabs.SUBSCRIPTION"
          :venue="venue"
          :loading="loading"
          :prices="prices"
          @create="subscriptionCreate"
          @cancel="subscriptionCancel"
        ></manage-subscription-component>
        <div
          class="
            flex
            items-center
            justify-end
            col-span-2
            p-4
            mb-8
            md:mb-0
            bg-grey-100
          "
          v-if="
            venueManageTab !== manageTabs.TICKETS &&
            venueManageTab !== manageTabs.SUBSCRIPTION
          "
        >
          <button
            @click="updateDetails"
            class="
              flex
              items-center
              justify-center
              px-3
              py-2
              ml-2
              text-sm text-white
              bg-orange-200
              rounded-lg
              disabled:opacity-50
            "
            :disabled="loading"
          >
            <icon name="save" class="w-4 h-4 mr-2" />
            {{ editMode ? "Update details" : "Create Venue" }}
          </button>
        </div>
      </div>
    </div>
    <page-spinner-component v-if="loading" />
  </div>
</template>

<script>
import { mapState } from "vuex";
import { manageTabs } from "../../store/state";
import { formatDateAPI } from "../../utils";
export default {
  computed: {
    ...mapState({
      venue: (state) => state.venueDetail,
      live: (state) => state.live,
      basket: (state) => state.basket,
      venueDetail: (state) => state.venueDetail,
      loggedIn: (state) => state.user.loggedIn,
      user: (state) => state.user,
      manageVenueNewTicket: (state) => state.manageVenueNewTicket,
      loading: (state) => state.loading,
      manageVenueErrorFields: (state) => state.manageVenueErrorFields,
      editMode: (state) => state.venueDetail?.id > 0,
      venueSearch: (state) => state.venueSearch,
      venueManageClosed: (state) => state.venueManageClosed,
      venueManageTab: (state) => state.venueManageTab,
      prices: (state) => state.prices,
    }),
  },
  data: () => {
    return {
      manageTabs,
      TABS: [
        {
          index: manageTabs.DETAILS,
          label: "Details",
        },
        {
          index: manageTabs.HOURS,
          label: "Opening Days",
        },
        {
          index: manageTabs.PAYMENT,
          label: "Payment",
        },
        {
          index: manageTabs.LOCATION,
          label: "Location",
        },
        {
          index: manageTabs.TICKETS,
          label: "Tickets",
        },
        {
          index: manageTabs.SUBSCRIPTION,
          label: "Subscription",
        },
      ],
    };
  },
  mounted() {
    if (this.$route.query.tab) {
      const tabIndex = this.TABS.findIndex((f) => {
        return f.label === this.$route.query.tab;
      });
      if (tabIndex > -1) {
        this.setTab(this.TABS[tabIndex].index);
      }
    }
  },
  methods: {
    setTab(tab) {
      this.$store.dispatch("VENUE_MANAGE_TAB", tab);
    },
    subscriptionTab(event) {
      event.preventDefault();
      this.setTab(this.TABS.SUBSCRIPTION);
    },
    errorStyle(key) {
      return this.manageVenueErrorFields.indexOf(key) > -1
        ? " border-red-200"
        : "";
    },
    updateDetails() {
      const { user } = this;
      const {
        id,
        description,
        rules,
        account,
        address,
        phone,
        place_id,
        name,
        image,
        days,
        visible,
      } = this.venue;
      if (id > 0) {
        // update
        const venue = {
          id,
          name,
          description,
          rules,
          address,
          phone,
          account,
          place_id,
          open_sunday: days.sunday,
          open_monday: days.monday,
          open_tuesday: days.tuesday,
          open_wednesday: days.wednesday,
          open_thursday: days.thursday,
          open_friday: days.friday,
          open_saturday: days.saturday,
          visible,
        };
        this.$store.dispatch("VENUE_DETAILS_UPDATE", {
          venue,
          user,
        });
      } else {
        // create
        const venue = {
          name,
          description,
          account,
          rules,
          address,
          phone,
          place_id,
          image,
          open_sunday: days.sunday,
          open_monday: days.monday,
          open_tuesday: days.tuesday,
          open_wednesday: days.wednesday,
          open_thursday: days.thursday,
          open_friday: days.friday,
          open_saturday: days.saturday,
          visible,
        };
        this.$store.dispatch("VENUE_DETAILS_CREATE", {
          venue,
          user,
        });
      }
    },
    addNewTicket() {
      this.$store.dispatch("VENUE_TICKET_ADD");
    },
    saveTicket(details) {
      const { user } = this;
      const { id, name, description, cost, daily_limit } = details;
      const ticket = {
        id,
        name,
        description,
        cost,
        daily_limit,
      };
      this.$store.dispatch("VENUE_TICKET_SAVE", {
        venue_id: this.venue.id,
        ticket,
        user,
      });
    },
    deleteTicket(id) {
      const { user } = this;
      this.$store.dispatch("VENUE_TICKET_DELETE", {
        venue_id: this.venue.id,
        id,
        user,
      });
    },
    uploadImage(event) {
      const { user } = this;
      const image = event.target.files[0];
      this.$store.dispatch("VENUE_IMAGE_UPLOAD", {
        venue_id: this.venue.id,
        image,
        user,
      });
    },
    deleteImage() {
      const { user } = this;
      this.$store.dispatch("VENUE_IMAGE_DELETE", {
        venue_id: this.venue.id,
        user,
      });
    },
    venueClosedStart(date) {
      this.$store.dispatch("VENUE_CLOSED_START", date);
    },
    venueClosedEnd(date) {
      this.$store.dispatch("VENUE_CLOSED_END", date);
    },
    venueClosedAdd() {
      const { start, end } = this.venueManageClosed;
      const { user } = this;
      this.$store.dispatch("VENUE_CLOSED_ADD", {
        start: formatDateAPI(start),
        end: formatDateAPI(end),
        venue_id: this.venue.id,
        user,
      });
    },
    venueClosedDelete(id) {
      const { user } = this;
      this.$store.dispatch("VENUE_CLOSED_DELETE", {
        id,
        venue_id: this.venue.id,
        user,
      });
    },
    subscriptionCreate() {
      const { user } = this;
      this.$store.dispatch("SUBSCRIPTION_CREATE", {
        venue_id: this.venue.id,
        user,
      });
    },
    subscriptionCancel() {
      const { user } = this;
      this.$store.dispatch("SUBSCRIPTION_CANCEL", {
        venue_id: this.venue.id,
        user,
      });
    },
    accountCreate() {
      const { user } = this;
      this.$store.dispatch("STRIPE_ACCOUNT_CREATE", {
        venue_id: this.venue.id,
        user,
      });
    },
  },
};
</script>
