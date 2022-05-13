<template>
  <div class="w-full max-w-5xl p-4 mx-auto">
    <h2 class="flex items-center mb-4 text-xl font-semibold">{{ title }}</h2>
    <div v-if="path == 'complaints'">
      <p class="mb-4 font-semibold">
        WE DEAL WITH COMPLAINTS IN A FAIR AND APPROPRIATE MANNER AND TRY TO
        RESOLVE ANY COMPLAINT TO THE SATISFACTION OF ALL INVOLVED. WE HAVE
        THEREFORE ADOPTED THE FOLLOWING COMPLAINTS PROCEDURE FOR HANDLING
        COMPLAINTS. BEFORE DECIDING WHETHER OR NOT TO MAKE A COMPLAINT PLEASE
        REVIEW OUR T&amp;CS AS YOU MAY FIND THE ANSWER YOU ARE LOOKING FOR
        THERE.
      </p>
      <p class="mb-4 font-semibold">
        THIS COMPLAINTS POLICY DOES NOT AFFECT YOUR STATUTORY OR OTHER LEGAL
        RIGHTS.
      </p>
      <p class="mb-4 font-semibold">WHO IS YOUR COMPLAINT AGAINST</p>
      <p class="mb-4">
        If your complaint is about the services that we provide to you, we will
        deal with your complaint under the procedure below.
      </p>
      <p class="mb-4">
        If your complaint is about your experience or service received at the
        Fishery, in the first instance you should direct your complaint to the
        Fishery in question. If you are not satisfied with their response or
        resolution, then please contact us and we will try to remedy the
        situation between you and the Fishery. However, please note, we are not
        responsible for the actions or omissions of the Fishery and we cannot
        control or mandate that they do anything, including providing you with a
        resolution or remedy.
      </p>
      <p class="mb-4 font-semibold">HOW TO MAKE A COMPLAINT</p>
      <p class="mb-4">
        Any person wishing to make a complaint can do so by contacting us via
        one of the following methods: -
      </p>
      <p class="mb-4">
        Post:<br />
        Galgorm Holdings Limited<br />
        27-28 The Courtyard Galgorm Castle<br />
        BALLYMENA<br />
        BT42 1HL<br />
        UK
      </p>

      <p class="mb-4">
        Phone: +44 28 2565 6000 <br />
        GMT/BST 9.00am – 5.00pm (Monday to Friday, excluding 25 December)
      </p>

      <p class="mb-4">
        Email:
        <a href="mailto:support@GOFish.world" class="text-red-500"
          >support@GOFish.world</a
        >
      </p>
      <p class="mb-4">
        All complaints should be as detailed as possible and where applicable
        evidence should be provided. Please ensure you provide appropriate
        contact details so we can communicate with you.
      </p>
      <p class="mb-4">
        Please note we may require proof of identity before discussing or
        engaging with you about your complaint, we do this to make sure that we
        only communicate about personal issues with the relevant person or
        someone duly authorised on their behalf.
      </p>
      <p class="mb-4">
        We ask that when making your complaint you should be courteous and fair
        in your communications with us and our members of staff.
      </p>
      <p class="mb-4">
        Where possible we will endeavour to resolve your complaint at the time
        it is made. In the circumstances that we are unable to do so (for
        whatever reason), we will process your complaint into our Resolution
        Process below.
      </p>
      <p class="mb-4 font-semibold">HANDLING YOUR COMPLAINT</p>
      <p class="mb-4">
        Upon receipt of any complaint, your details will be processed and
        allocated to an appropriate member of our Customer Service team (Case
        Handler).
      </p>
      <p class="mb-4">
        Within 5 days the relevant Case Handler will acknowledge receipt of your
        complaint.
      </p>
      <p class="mb-4">The acknowledgement may also ask you to:</p>
      <p class="mb-4">
        (i) ​provide further information about the complaint; and/or<br />
        (ii) ​provide additional evidence to be reviewed as part of the
        complaint; and/or<br />
        (iii) ​provide proof of identity.
      </p>
      <p class="mb-4 font-semibold">RESOLUTION PROCESS – STAGE ONE</p>
      <p class="mb-4">
        We aim to resolve any complaint within 14 days of you making the
        complaint and providing relevant information. We will always confirm the
        outcome in writing to you (via email).
      </p>
      <p class="mb-4">
        Sometimes we may not have completed our investigations and therefore
        will need to extend the response time beyond the 14 days. We will always
        keep you updated with timescales as and when necessary.
      </p>
      <p class="mb-4 font-semibold">RESOLUTION PROCESS – STAGE TWO</p>
      <p class="mb-4">
        If you are not happy with our response at Stage One, you may request a
        review of your complaint by Head of Complaints. Your request must be
        sent to the above email address who will forward the request to the Head
        of Complaints for the review.
      </p>
      <p class="mb-4">
        You should expect an acknowledgement to your request within 5 days and a
        full response within 14 days (from the date of your request) unless we
        let you know otherwise.
      </p>
      <p class="mb-4 font-semibold">CONFIDENTIALITY &amp; RECORD KEEPING</p>
      <p class="mb-4">
        All complaints received will be dealt with confidentially and in
        accordance with data protection laws and our Privacy Policy.
      </p>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { contentTitle } from "../../utils";
export default {
  computed: {
    ...mapState({
      path: (state) => state.path,
      title: (state) => contentTitle(state.path),
    }),
  },
};
</script>
