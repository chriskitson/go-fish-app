<template>
  <div class="w-full max-w-5xl p-4 mx-auto content-page">
    <h2 class="flex items-center mb-4 text-xl font-semibold">
      {{ title }}
    </h2>

    <div v-if="path === 'about'">
      <p>
        GOFish was launched in 2022 by Trevor Finlay from Ballymena, N. Ireland.
        Trevor is an avid fly-fisherman and was frustrated at how difficult it
        was to make advance bookings for any of his fishing trips.
      </p>
      <p>
        The platform has been built on Google Cloud and has provides Fisheries
        with a simple sign-up process and way to setup and manage their calendar
        and available tickets.
      </p>

      <p>
        Anglers can easily find and book fisheries throughout the country, and
        find up-to-date information on fishery tickets, amenities and other
        services.
      </p>

      <p>
        For more information please
        <a href="mailto:info@gofish.world" class="text-red-500"
          >info@gofish.world</a
        >.
      </p>
    </div>
    <div v-if="path === 'contact'">
      <p>Head Office:<br /></p>
      <p>
        Galgorm Holdings Limited<br />
        27-28 The Courtyard Galgorm Castle<br />
        BALLYMENA<br />
        BT42 1HL<br />
        UK
      </p>

      <p>Phone: +44 28 2565 6000</p>
      <p>GMT/BST 9.00am – 5.00pm (Monday to Friday, excluding 25 December)</p>

      <p>
        Email:
        <a href="mailto:support@GOFish.World" class="text-red-500"
          >support@GOFish.World</a
        >
      </p>
    </div>
    <div v-if="path == 'privacy'">
      <p>INFORMATION CAPTURE OVERVIEW</p>

      <p>
        To help us give you more of what you love, we capture information about
        you in order to improve your experience of the GoFish Community.
      </p>

      <p>
        We are Galgorm Holdings Limited trading as GOFish of 27-28 The Courtyard
        Galgorm Castle, Ballymena, Co. Antrim, BT42 1HL, United Kingdom and we
        are a Data Controller registered with the UK Information Commissioner’s
        Office. Our Data Protection Officer is Mr David Preston and is
        contactable via david@gofish.world
      </p>

      <p>
        This notice is to inform you about how we collect and protect any
        personal information you provide to us and how you can control what
        personal information we collect from you and what we do with it. It sets
        out how we intend to use your information, who we will share it with and
        what rights you have about use of your information. This notice applies
        however you provide personal information to us, whether you go online to
        our websites, contact us via social media, visit our events and stores ,
        enter competitions, engage in research activities or whether you
        telephone, email, write to or text us.
      </p>

      <p>WHAT PERSONAL DATA DO WE COLLECT?</p>

      <p>We may collect the following information about you:</p>

      <ul>
        <li>
          your name, age/date of birth, gender and other relevant demographic
          information;
        </li>
        <li>
          your contact details: postal address including billing and delivery
          addresses, telephone numbers (including mobile numbers) and email
          address;
        </li>
        <li>your social media handles;</li>
        <li>your social media handles;</li>
        <li>purchases and orders made by you;</li>
        <li>
          your online browsing activities on any of our websites including which
          items you store in your shopping cart;
        </li>
        <li>
          information about the device you use to browse our websites including
          the IP address and device type;
        </li>
        <li>your communication and marketing preferences;</li>
        <li>
          your interests, preferences, feedback, competition and survey
          responses;
        </li>
        <li>your location;</li>
        <li>your correspondence and communications with us; and</li>
        <li>
          other publicly available personal data, including any which you have
          shared via a public platform (such as Instagram, YouTube, Twitter or
          public Facebook page).
        </li>
      </ul>

      <p>
        This list is not exhaustive and in specific instances, we may need to
        collect additional data for the purposes set out in this Notice. Some
        personal data is collected directly, for example when you set up an
        online account on our website or send an email to our Customer Support
        team. Other personal data is collected indirectly, for example when you
        browse our websites or undertake online shopping activity. We may also
        collect personal data from third parties who have your consent to pass
        your details to us, or from publicly available sources. We may anonymise
        and aggregate personal data for insight and research but this will not
        identify anyone.
      </p>

      <p>
        Our websites are not intended for children and we do not knowingly
        collect data relating to children.
      </p>

      <p>General</p>

      <p>
        Galgorm Holdings Limited (and trusted partners acting on our behalf) use
        your personal data:
      </p>

      <ul>
        <li>to provide goods and services to you;</li>
        <li>to make a tailored website available to you;</li>
        <li>to manage any account(s) you hold with us;</li>
        <li>to verify your identity;</li>
        <li>for crime and fraud prevention, detection and related purposes;</li>
        <li>
          with your agreement, to contact you about promotional offers, events,
          products and services which we think may interest you;
        </li>
        <li>
          to show you promotional communications through online media as you
          browse the web;
        </li>
        <li>
          for analysis, insight and research purposes - to better understand
          your needs and ensure we are giving you what you want;
        </li>
        <li>to identify and contact competition winners;</li>
        <li>
          to enable us to manage customer service interactions with you; and
        </li>
        <li>
          where we have a legal right or duty to use or disclose your
          information (for example in relation to an investigation by a public
          authority or in a legal dispute).
        </li>
        <li>Marketing</li>
        <li>Promotional communications</li>
      </ul>

      <p>
        To ensure you are kept up to date with Community news, we use personal
        data for marketing purposes and may send you postal mail, texts,
        WhatsApp messages and/or emails to update you on the latest offers and
        events. We may also show you online media communications through
        external social media platforms such as Facebook and Instagram and
        external digital advertisers such as Google.
      </p>

      <p>
        You have the right to opt out of receiving promotional communications at
        any time, by:
      </p>

      <ul>
        <oi
          >informing us that you wish to change your marketing preferences by
          contacting our customer support team at support@gofish.world</oi
        >
        <oi
          >making use of the simple “unsubscribe” link in emails or the “STOP”
          number for texts; and/or</oi
        >
        <oi
          >contacting our Data Protection Officer Mr Trevor Finlay via email at
          trevor@gofish.world or by post to the Data Protection Officer, Galgorm
          Holdings Limited, 27-28 The Courtyard Galgorm Castle, BALLYMENA, Co.
          Antrim, BT42 1HL.</oi
        >
        <oi>This may not stop service messages such as order updates.</oi>
      </ul>

      <p><strong>Personalisation and Automated Decision Making</strong></p>

      <p>
        If you visit any of our websites, you may receive personalised banner
        advertisements whilst browsing websites of other companies. Any banner
        advertisements you see will relate to your browsing activity on our
        website from your computer or other devices.
      </p>

      <p>
        These advertisements are provided by us via external market leading
        specialist providers using techniques such as pixels, web beacons, ad
        tags, mobile identifiers and ‘cookies’ placed on your computer or other
        devices (see further information on the use of cookies in our Cookie
        Policy). You can remove or disable cookies at any time - see Cookie
        Policy for further information.
      </p>

      <p>
        We may collect data directly from you, as well as analysing your
        browsing and purchasing activity online and your responses to marketing
        communications. The results of this analysis, together with other
        demographic data, allow us to ensure that we contact you with
        information on products, services, events and offers that are tailored
        and relevant to you. To do so, we use software and other technology for
        automated decision making. We may do this to decide what marketing
        communications are suitable for you and this activity is based on our
        legitimate interests to develop and improve our products and services.
      </p>

      <p>
        Also to provide more personalised services and experiences, we may
        review data held by external social media platform providers about you,
        for example, details on your Twitter or Facebook profiles that you have
        chosen to make publicly accessible such as your name, date of birth.
        Some of our services enable you to sign-in via external social media
        platform providers such as Facebook. If you choose to sign-in via a
        third party app, you will be presented with a dialog box which will ask
        your permission to allow us to access your personal information (e.g.
        your full name, date of birth, email address and any other information
        you have made accessible).
      </p>

      <p>
        We aim to update you about products and services which are of interest
        and relevance to you as an individual. To help us do this, we process
        data by profiling and segmenting, identifying what our customers like
        and ensuring messages we send them are relevant based on their
        demographics, interests, purchase behaviour, online web browsing
        activity and engagement with previous communications. We may also use
        your data to exclude you from communications which we feel are
        irrelevant to you. For example, we may exclude someone from resends of
        marketing emails when we know that person has already opened the
        original email sent.
      </p>

      <p>
        Another example of how we may tailor our communications with you is that
        we may group individuals with similar interests using this data so we
        can send them product news or promotional offers that are relevant to
        that shared interest.
      </p>

      <p>
        External Service Provider - Companies that help us provide our goods to
        you including providers of ecommerce platforms and payment, logistics,
        delivery, courier and returns management services: -
      </p>

      <ul>
        <li>
          Reason for sharing your data: We have help from outside organisations
          in order to ensure we can provide our products and services to you.
        </li>
        <li>
          Example: Making sure that the fisheries know about your booking and
          identity.
        </li>
      </ul>

      <p>
        External Service Provider - Companies that help us provide a better
        experience tailored to you including providers of intelligence tools and
        social media platforms, providers of website hosting, marketing and
        advertising services and organisers of discount and loyalty schemes.
      </p>

      <ul>
        <li>
          Reason for sharing your data: We want to make sure that we are always
          relevant, completely understand you and give you the best customer
          journey to ensure we can tailor your experience, reach you in the
          platforms you enjoy using and save you time.
        </li>
        <li>
          Example: Using information about your previous purchases and what you
          store in your shopping cart to show you, through channels such as
          social media or emails, product recommendations and let you know when
          new products release.
        </li>
      </ul>

      <p>
        The optional use of sign in for our website through external site
        operators such as Facebook, Google, Instagram and Stripe.
      </p>
      <p>
        Understanding the device that you use to browse our websites to improve
        your shopping experience.
      </p>

      <p>External Service Provider - Fraud Prevention agencies</p>

      <ul>
        <li>
          Reason for sharing your data: To help tackle fraud we pass data
          through fraud prevention tools operated by external companies.
        </li>
        <li>
          Example: Validating your details when you make a purchase on our
          website.
        </li>
      </ul>

      <p>
        You have the right to opt out of any automated processing, including
        profiling, at any time by informing us that you wish to opt out of
        automated processing by contacting our customer support team at
        support@gofish.world and / or contacting our Data Protection Officer via
        email to david@gofish.world or post to Data Protection Officer, Galgorm
        Holdings Limited, 27-28 The Courtyard Galgorm Castle, Ballymena, Co.
        Antrim, BT42 1HL, United Kingdom.
      </p>

      <p><strong>COOKIES</strong></p>

      <p>
        Our websites use cookies to capture information. This includes
        information about browsing and purchasing behaviour by people who access
        our websites, including pages viewed, products purchased and customer
        journey around our websites.
      </p>

      <p>
        Detailed information is set out in our Cookie Policy and is provided to
        ensure you are fully aware of the cookies we use, allowing you to make
        an informed choice about your acceptance of cookies.
      </p>

      <p><strong>SHARING DATA WITH THIRD PARTIES</strong></p>

      <p>Our service providers and suppliers</p>

      <p>
        In order to make certain services available to you and to help us better
        understand your preferences, we have partnered with certain trusted
        third parties including logistics and marketing service providers. We
        may need to share your personal information with some of our service
        partners. We only allow our service providers to handle your personal
        information when they have confirmed that they apply appropriate data
        protection and security controls. We also impose contractual obligations
        on service providers relating to data protection and security, which
        mean they can only use your information to provide services to us and to
        you, and for no other purposes. We may provide outside companies with
        aggregated and anonymised information and analytics about our customers
        but that would never identify you and we will never sell or rent your
        personal information to other organisations for any purposes.
      </p>

      <p>
        To help you understand which partners we share data with, here are the
        types of companies with whom we share data in order to provide and
        promote our goods and services:
      </p>

      <p>Other third parties</p>

      <p>We may also share your data with:</p>

      <ul>
        <li>other companies within our group;</li>
        <li>
          to purchasers, investors, funders and advisers if we sell our business
          or assets or restructure whether by merger, re-organisation or
          otherwise;
        </li>
        <li>
          our legal and other professional advisers, including our auditors;
        </li>
        <li>credit reference agencies where necessary for card payments;</li>
        <li>
          governmental bodies, regulators, law enforcement agencies,
          courts/tribunals and insurers where we are required to do so: -
        </li>
      </ul>

      <ul>
        <li>
          to comply with our legal obligations and the administration of
          justice;
        </li>
        <li>to exercise our legal rights (for example in court cases);</li>
        <li>
          for the prevention, detection, investigation of crime or prosecution
          of offenders; and
        </li>
        <li>for the protection of our employees and customers.</li>
      </ul>

      <p><strong>LEGAL BASIS FOR USING DATA</strong></p>
      <p>
        We are required to set out the legal basis for our processing of your
        personal data.
      </p>

      <p>We collect and use customers’ personal data:</p>

      <ul>
        <li>as necessary to perform our contract with you:</li>
        <li>
          for the purposes of complying with our duties and exercising our
          rights under a contract for the sale of goods or services to a
          customer; or
        </li>
        <li>
          as necessary for the pursuit of our legitimate interests, including:
        </li>
        <li>selling and supplying goods and services to our customers;</li>
        <li>promoting, marketing and advertising our products and services;</li>
        <li>
          sending promotional communications which are relevant and tailored to
          individual customers (including administering loyalty schemes);
        </li>
        <li>to identify and contact competition winners;</li>
        <li>
          understanding our customers’ behaviour, activities, preferences, and
          needs;
        </li>
        <li>
          improving existing products and services and developing new products
          and services;
        </li>
        <li>
          protecting customers, employees and other individuals and maintaining
          their safety, health and welfare;
        </li>
        <li>
          good governance, accounting and managing and auditing our operations
          and complying with our legal and regulatory obligations;
        </li>
        <li>
          preventing, investigating and detecting crime, fraud or anti-social
          behaviour and prosecuting offenders, including working with law
          enforcement agencies;
        </li>
        <li>handling customer contacts, queries, complaints or disputes;</li>
        <li>
          protecting our company, its employees and customers, by taking
          appropriate legal action against third parties who have committed
          criminal acts or are in breach of legal obligations to us;
        </li>
        <li>
          handling any legal claims or regulatory enforcement actions taken
          against us; and
        </li>
        <li>
          fulfilling our duties to our customers, colleagues, shareholders and
          other stakeholders;
        </li>
        <li>
          as necessary for complying with our legal obligations including:
        </li>
        <li>where you exercise your rights under data protection laws</li>
        <li>for compliance with legal and regulatory requirements;</li>
        <li>to establish or defend legal rights;</li>
        <li>or</li>
        <li>
          based on your consent for example in relation to sending direct
          marketing communications via email or text message.
        </li>
        <li>
          You have the right to withdraw consent at any time. Where consent is
          the only legal basis for processing, we will cease to process data
          after consent is withdrawn.
        </li>
      </ul>

      <p><strong>HOW WE PROTECT YOUR DATA</strong></p>

      <p>Our controls</p>

      <p>
        Galgorm Holdings Limited is committed to keeping your personal data safe
        and secure. Our security measures include: -
      </p>

      <ul>
        <li>encryption of data;</li>
        <li>
          regular cyber security assessments of all service providers who may
          handle your personal data;
        </li>
        <li>
          regular planning to ensure we are ready to respond to cyber security
          attacks and data security incidents;
        </li>
        <li>daily penetration testing of systems;</li>
        <li>
          security controls which protect our IT systems infrastructure and our
          premises from external attack and unauthorised access;
        </li>
        <li>
          internal policies setting out our data security rules for our
          personnel; and
        </li>
        <li>regular training for our employees.</li>
      </ul>

      <p><strong>WHAT YOU CAN DO TO HELP PROTECT YOUR DATA</strong></p>

      <p>
        You should always be cautious when sharing your personal data. No one
        from our company will ever ask you to confirm any bank account or credit
        card details via email. If you receive an email claiming to be from
        GOFish asking you to do so, please ignore it and do not respond.
      </p>

      <p>
        If you are using a computing device in a public location, we recommend
        that you always log out and close the website browser when you complete
        an online session.
      </p>

      <p>
        In addition, we recommend that you take the following security measures
        to enhance your online safety: -
      </p>

      <ul>
        <li>
          keep your account passwords private because anyone who knows your
          password may access your account or be compromised if your account is
          accessed without authority.
        </li>
        <li>
          when creating a password, use a difficult word/number combination of
          at least 8 characters and something that is not easily guessed by
          hackers such as your name, email address, or other personal data that
          can be easily obtained. Also, frequently change your password. You can
          do this in your account settings.
        </li>
        <li>avoid using the same password for different online accounts</li>
      </ul>

      <p><strong>HOW LONG WE KEEP YOUR DATA</strong></p>
      <p>
        We will not retain your data for longer than necessary for the purposes
        set out in this Notice. Different retention periods apply for different
        types of information, and our Data Retention Policy sets out the length
        of time we will usually retain personal data and where these default
        periods might be changed.
      </p>

      <p>
        In summary, various laws, accounting and regulatory requirements
        applicable to us require us to retain certain records for specific
        amounts of time. In relation to your personal data, we will hold this
        only for so long as we require that personal data for legal or
        regulatory reasons or for legitimate organisational purposes. We will
        not keep your data for longer than is necessary for the purposes for
        which we collect them.
      </p>

      <p><strong>INTERNATIONAL TRANSFERS OF YOUR DATA</strong></p>
      <p>
        To deliver products and services to you, it is sometimes necessary to
        share your personal information outside of the European Economic Area
        (the EEA). This will typically occur when service providers are located
        outside the EEA or if you are based outside the EEA. These transfers are
        subject to special rules under data protection laws.
      </p>

      <p>
        If we transfer your personal information outside the EEA, we will ensure
        that the transfer will be compliant with data protection law and all
        personal data will be secure. Our standard practice is to assess the
        laws and practices of the destination country and relevant service
        provider and the security measures that are to be taken as regards the
        data in the overseas location; alternatively, we use standard data
        protection clauses.
      </p>

      <p><strong>YOUR RIGHTS</strong></p>

      <p>You have the following rights:</p>

      <ul>
        <li>
          the right to be informed about our processing or your personal data
          which is the aim of this Notice;
        </li>
        <li>
          the right to request access to personal data we hold about you at any
          time;
        </li>
        <li>
          the right to ask us to update and correct any out-of-date or incorrect
          personal data that we hold about you;
        </li>
        <li>
          the right to object to processing of your personal data and/ or to
          withdraw any consent you have given us and to opt out of any marketing
          communications that we may send you;
        </li>
        <li>
          the right to prevent processing that is likely to cause damage or
          distress to you or anyone else;
        </li>
        <li>
          the certain rights in relation to automated decision making including
          profiling;
        </li>
        <li>
          the right to request that we erase your personal data in certain
          circumstances (the right to be forgotten) for example when the data
          are no longer necessary for the purpose for which we collected them;
        </li>
        <li>
          the right to have your personal data provided to you by us in a
          structured, commonly used and machine-readable format and transmitted
          to another data controller. This is known as the right to data
          portability.
        </li>
      </ul>

      <p>
        If you wish to exercise any of the above rights, you can always contact
        us either by email to trevor@gofish.world or by post to the Data
        Protection Officer, Galgorm Holdings Limited, 27-28 The Courtyard
        Galgorm Castle, Ballymena, Co. Antrim, BT42 1HL, United Kingdom
      </p>

      <p>
        You have the right to lodge a complaint with the Information
        Commissioner’s Office at Wycliffe House, Water Lane, Wilmslow, SK9 5AF,
        United Kingdom if you believe we have not handled your personal data in
        accordance with the law. Further information, including contact details,
        is available at https://ico.org.uk.
      </p>

      <p>
        Galgorm Holdings Limited, 27-28 The Courtyard Galgorm Castle, Ballymena,
        Co. Antrim, BT42 1HL, United Kingdom
      </p>

      <p>Last Updated: March 12, 2022</p>
    </div>
    <div v-if="path == 'terms'">
      <p><strong>GOFISH TERMS AND CONDITIONS</strong></p>

      <p>Effective date 4 March 2022</p>

      <p>
        <strong
          >THE FOLLOWING TERMS AND CONDITIONS (T&CS) GOVERN THE SALE OF FISHING
          TICKETS & HOT SPOTS TICKETS PURCHASED VIA THE WEBSITE AND/OR VIA THE
          MOBILE APP, TOGETHER WITH ANY APPLICABLE TERMS AND CONDITIONS
          STIPULATED BY THE FISHERY, WHICH MAY BE FOUND ON THE WEBSITE, MOBILE
          APP OR ON THE FISHERY’S OWN WEBSITE.</strong
        >
      </p>
      <p>
        <strong
          >BY BOOKING A FISHING TICKET OR HOT SPOTS YOU WARRANT THAT YOU HAVE
          READ AND AGREE TO BE BOUND BY THESE T&CS.</strong
        >
      </p>

      <p><strong>1. OUR ROLES</strong></p>
      <p>
        GOFish provides a way for You (‘You’, ‘Anglers’) to book Fishing Tickets
        (‘Fishing Tickets’) and Hot Spots Tickets (‘Hot Spots’) at hundreds of
        individual Fisheries (‘Fishery’) displayed on www.GOFish.world,
        affiliated websites and/or the GOFish UK&I mobile app (collectively
        referred to as the ‘Website(s)’)
      </p>
      <p>
        1.2 The legal contract for a Fishing Ticket is between You and the
        Fishery, and GOFish acts on behalf of and as an agent for the Fishery in
        question. GOFish is paid a commission by the Fishery for this service.
        The legal contract for Hot Spots Tickets is between You and GOFish.
        Please see Condition 7 for more details.
      </p>
      <p>
        1.3 Where the Fishery’s terms and conditions are not featured on the
        Websites, You should check the website of the Fishery in question for
        any applicable terms that You need to be aware of, such as bait types,
        hook sizes, fish handling policy or similar rules. In addition, the
        Fishery may operate a different cancellation policy, which will override
        any cancellation terms within these T&Cs (‘Fishery Rules’).
      </p>

      <p><strong>>2. HOW TO BOOK A FISHING TICKET</strong></p>

      <p>
        2.1 Once you have selected the Fishing Ticket or Hot Deal you wish to
        reserve at your chosen Fishery, you can either check out as a guest
        using your email address or create or sign into your GOFish account.
      </p>
      <p>
        2.2 Once you have provided your payment details you should click “Book
        Now” in order to complete your booking.
      </p>
      <p>
        2.3 On receipt of your booking, GOFish will notify you by email that
        your booking has been received and is being processed. Please note that
        any confirmation page or any confirmation e-mail that you may receive
        does not mean that your booking will be fulfilled by the Fishery. GOFish
        encourages all the Fisheries to accept all bookings and to communicate
        any rejection promptly.
      </p>
      <p>
        2.4 GOFish (and/or the Fishery) will notify you (by email or telephone)
        as soon as is reasonably practicable if the Fishery rejects your
        booking. In such circumstances your rights are set out in Condition 4.
      </p>

      <p><strong>3. YOUR RESPONSIBILITIES</strong></p>
      <p>
        3.1 You (including any additional Anglers included within your booking)
        are responsible for:
      </p>
      <p>Ensure your booking information is correct at the time of booking.</p>
      <p>Acting always in accordance with the Fishery Rules.</p>
      <p>
        Arriving in good time before your allocated Fishing Ticket or Hot Spots
        Fishing Ticket (if you are running late, please contact the Fishery as
        soon as possible. Please note, Fishing Tickets and Hot Spots are subject
        to availability and there is no guarantee that the Fishery will be able
        to accommodate a new Fishing Ticket if you miss your original time).
      </p>
      <p>
        Providing proof of your booking and payment, if requested by Fishery.
      </p>
      <p>Communicating any special requirements in advance to the Fishery.</p>
      <p>
        Checking the condition of the Fishery on the day in advance of your
        Fishing Ticket or Hot Spots to ensure the Fishery is open and
        accessible.
      </p>
      <p>3.2 You accept that:</p>
      <p>
        The Fishery has discretion to refuse entry or request that you leave
        (including any Angler within your booking) that does not adhere to the
        Fishery Rules.
      </p>
      <p>
        The time of the Fishing Ticket you book is an estimate only. Neither
        GOFish nor the Fishery guarantee that you will be able to fish at the
        exact time you have booked and will not be responsible for any delay.
      </p>
      <p>
        Owing to local conditions, some banks at the Fishery may be closed for
        maintenance.
      </p>
      <p>
        There may other situations which may affect your experience at the
        Fishery.
      </p>
      <p>
        Where you have any complaints, these should be directed to the Fishery
        in the first instance for resolution.
      </p>
      <p>GOFish has no control over the actions or omissions of the Fishery.</p>

      <p><strong>4. CANCELLATIONS AND AVAILABILITY</strong></p>
      <p>
        4.1 Once you have submitted your booking, unless otherwise stated, you
        will not be entitled to change or cancel your Fishing Ticket and you
        will not be entitled to a refund.
      </p>
      <p>
        4.2 If you are trying to change or cancel your Fishing Ticket in
        accordance with any cancellation policy, please contact Customer Support
        and we will communicate with the Fishery. Please note there is no
        guarantee that the Fishery will agree to your requests unless the
        cancellation policy provides anything to the contrary.
      </p>
      <p>
        4.3 Please note the individual Fishery is responsible for updating their
        ticket availability and opening hours (the electronic system that
        manages their available Fishing Tickets). Where they fail to do so,
        GOFish may advertise Fishing Tickets on the Websites that are not
        actually available for purchase. Where it is subsequently realised that
        such Fishing Tickets were not available for sale (for example the
        Fishery has not informed GOFish that the Fishery has a competition on
        your booking date), GOFish’s liability to you is limited, at its
        discretion, to a refund of the cost of the booking (including Booking
        Fees) or to issue you with credit (to the same value including Booking
        Fees) to be used against your next booking(s) (please note any credit
        issued must be used within six (6) months of being issued).
      </p>

      <p><strong>5. PRICE AND PAYMENT</strong></p>
      <p>
        5.1 Prices for Fishing Tickets and Hot Spots will be as quoted on the
        Websites. These prices include any applicable VAT (these will be added
        to the total amount due where applicable) but are exclusive of Booking
        Fees (these are added at the checkout).
      </p>
      <p>
        5.2 Booking Fees are applied to each Angler within a booking (some of
        your bookings may be exempt from Booking Fees, for example if you are a
        TopAngler). Booking Fees help GOFish run the platform, add and update
        features and offer services like Customer Support.
      </p>
      <p>
        5.3 The Websites contain many Fishing Tickets and Hot Spots and it is
        possible that some of the Fishing Tickets or Hot Spots may be advertised
        at an incorrect price. In such an event, neither GOFish or the relevant
        Fishery is under any obligation to ensure that the Fishing Ticket or Hot
        Spots are provided to you at the advertised incorrect price or to
        compensate you in respect of any incorrect pricing. GOFish’s liability
        to you is limited to a full refund of the price you have paid (including
        Booking Fees) and/or credit (to the same value including Booking Fees)
        to be used against your next booking(s) (please note any credit issued
        must be used within six (6) months of being issued).
      </p>
      <p>
        5.4 Unless stated otherwise, you should not make any additional payments
        for your Fishing Ticket or Hot Spots when you arrive at the Fishery. If
        you are required to make a payment by the Fishery upon your arrival, you
        should contact us immediately. If you make a payment before contacting
        us, unfortunately, we will not be able to assist you further, other than
        to communicate with the Fishery to issue you with an applicable refund.
        This does not affect your statutory rights.
      </p>

      <p><strong>6. PAYMENTS</strong></p>
      <p>
        6.1 Unless stated otherwise, payments for Fishing Tickets or Hot Spots
        must be made in advance by an accepted credit or debit card through the
        Website (some credit or debit cards may not be accepted such as American
        Express).
      </p>
      <p>
        6.2 Transactions will appear on the cardholder's bank or card statement
        will usually show as the Fishery or GOFish, but this cannot be precisely
        is not guaranteed.
      </p>

      <p><strong>7. COMMISSION AND HOT SPOTS</strong></p>
      <p>
        7.1 The contract for a Fishing Ticket will always be between you and the
        Fishery in question. The Fishery and GOFish have a commercial agreement
        in place, whereby the Fishery will pay GOFish a commission fee for
        advertising and facilitating the sale of your Fishing Ticket between you
        and the Fishery.
      </p>
      <p>
        7.2 Instead of commission fees or where GOFish provides the Fishery with
        additional services, the Fishery may opt to provide GOFish with
        exclusive Fishing Tickets (which are usually discounted) to advertise on
        the Websites, these are known as Hot Spots. When you purchase a Hot
        Spots Fishing Ticket you are entering into a legal contract with GOFish.
      </p>
      <p>
        7.3 Hot Spots are non-cancellable and non-refundable. Where you are
        unable to attend your Hot Spots (for whatever reason), our total
        liability to you is limited to the value of the Hot Spots booking
        (including Booking Fees) or to issue you with credit (to the same value
        of the Hot Spots booking including Booking Fees) to be used against your
        next Hot Spots booking(s) (please note any credit issued must be used
        within six (6) months of being issued).
      </p>

      <p><strong>8. DISCOUNT VOUCHERS, PROMO CODES & OFFERS</strong></p>
      <p>
        >8.1 The following general terms and conditions will apply to all
        discounts, promo codes & offers (‘Promo’) issued from time to time for
        use on the Websites (‘Promo Terms’)
      </p>
      <p>
        8.2 The Promo Terms will be supplemented and/or modified by, additional
        terms and conditions (the ‘Specific Promo Terms’) as specified on or
        with the Promo Terms. For completeness, if there is any conflict between
        the Promo Terms and the Specific Promo Terms, the Specific Promo Terms
        will take precedent.
      </p>
      <p>
        8.3 Unless stated otherwise, standard Fishery Fishing Tickets are exempt
        from Promos, they only apply to Hot Spots.
      </p>
      <p>8.4 To use a Promo Code, you must:</p>
      <p>have a GOFish account and be signed in; and</p>
      <p>enter the Promo Code as provided (case sensitive).</p>
      <p>8.5 Unless stated otherwise, the Promo Code:</p>
      <p>
        will only be valid for one time use against one individual Hot Spots as
        advertised from time to time;
      </p>
      <p>
        must be used by the deadline specified and/or at the time the Promo Code
        is issued and will expire if not used by any such date;
      </p>
      <p>
        >can only be used by the person given the Promo Code and not by any
        other person;
      </p>
      <p>
        cannot be combined with any other offers, promotions, coupons, or
        discounts; and
      </p>
      <p>may be withdrawn or modified at any time without notice.</p>
      <p>
        8.6 The Promo Code is non-transferable and has no cash value. Where the
        Promo Code is for a fixed amount that is:
      </p>
      <p>
        less than the Hot Spots price, you will be responsible to pay the
        shortfall in order for the booking to be processed;
      </p>
      <p>
        more than the Hot Spots price, then unless otherwise agreed, the
        remaining balance will be forfeited.
      </p>
      <p>
        8.7 Please note Hot Spots Fishing Tickets are limited so there is no
        guarantee that a Promo Code can be used against desired Hot Spots. Hot
        Spots Fishing Tickets are only available at some participating Fisheries
        and are subject to change at any time.
      </p>
      <p>
        8.8 When you use a Promo Code you represent that you are the authorised
        recipient of the Promo and that you are using it in accordance with
        these T&Cs and in good faith. If we believe in our sole discretion that
        a Promo Code is being used in breach of these T&Cs, illegally or in bad
        faith, we may reject or cancel the Promo Code (and any associated
        booking made with it) without notice to you.
      </p>

      <p><strong>9. DATA PROTECTION</strong></p>
      <p>
        9.1 We take our responsibilities and obligations in respect of data
        protection extremely seriously. Please see our Privacy Policy to find
        out more information about how we collect and use your personal data
        through the Websites.
      </p>
      <p>
        9.2 We provide the Fishery with your booking details. They will only use
        your data to fulfil your booking. For example, they may contact you via
        your email address or telephone number to confirm your booking or to
        provide you with specific information you may need to know (i.e. the
        Fishery is closed due to bad weather). They will not contact you for any
        other reason unless permitted by law or you if have provided them with
        your details and given any applicable consents once you arrive at the
        Fishery.
      </p>
      <p>
        9.3 Through the Websites, we will seek your consent to send you
        marketing communications by email. You can unsubscribe from receiving
        these marketing communications at any time by using the links within
        each email, updating your account preferences or by contacting our
        Customer Service team.
      </p>
      <p>
        9.4 You should also review our Cookies Policy and Terms of Use for
        information regarding how and why we use cookies, including to improve
        the quality of the Websites and the user experience, perform analytics,
        personalise advertising, measure advertising performance and remembering
        preferences.
      </p>
      <p>
        9.5 Please visit our Privacy Policy for additional information on your
        rights to data access, deletion, objection and portability, as well as
        applicable retention periods.
      </p>

      <p><strong>10. LIABILITY</strong></p>
      <p>
        10.1 Unless expressly stated to the contrary and to the fullest extent
        permitted by law, we exclude all conditions, warranties and other terms
        which might otherwise be implied by statute or law. We shall not be
        liable for any damages whatsoever, including without limitation to any
        direct, indirect, special, consequential, punitive or incidental
        damages, or damages for loss of use, profits, data or other intangibles,
        damage to goodwill or reputation, or the cost of procurement of
        substitute goods and services, arising out of or related to your use,
        inability to use, performance or failures of the Websites, or the
        actions or omissions of any Fishery.
      </p>
      <p>
        10.2 GOFish’s total liability to you in respect of all other losses
        arising in connection with your Fishing Ticket and/or Hot Spots booking
        via our Websites, whether in contract, tort (including negligence),
        breach of statutory duty, or otherwise, shall in no circumstances be
        greater than; (i) double the value of your booking (including Booking
        Fees); or (ii) one hundred pounds/euros/dollars (£/€/$100).
      </p>
      <p>
        10.3 Nothing in these T&Cs excludes or limits GOFish’s liability for
        death or personal injury arising from our negligence, our liability for
        fraudulent misrepresentation, or any other liability which cannot be
        excluded or limited under applicable law.
      </p>

      <p><strong>11. MISCELLANEOUS</strong></p>
      <p>
        11.1 We reserve the right, at any time and in our sole discretion, to
        add to or amend these T&Cs.
      </p>
      <p>
        11.2 If any of these T&Cs are determined by any competent authority to
        be invalid, unlawful or unenforceable to any extent, such term,
        condition or provision will to that extent be severed from the remaining
        terms, conditions and provisions which will continue to be valid to the
        fullest extent permitted by law.
      </p>
      <p>
        11.3 Any failure or delay by you or us in enforcing (in whole or in
        part) any provision of these T&Cs will not be interpreted as a waiver of
        your or our rights or remedies.
      </p>
      <p>
        11.4 We will contact you by email, telephone or provide you with
        information by posting notices on the Websites. For contractual
        purposes, you agree to this electronic means of communication and you
        acknowledge that all contracts, notices, information and other
        communications that we provide to you electronically comply with any
        legal requirement that such communications be in writing. This condition
        does not affect your statutory rights.
      </p>
      <p>
        11.5 The cancellation rights contained in the Consumer Contracts
        (Information, Cancellation and Additional Charges) Regulations 2013 do
        not apply to the sale of Fishing Tickets or Hot Spots via the Websites.
      </p>

      <p><strong>12. DISPUTE RESOLUTION & COMPLAINTS</strong></p>
      <p>
        12.1 We are committed to delivering excellent customer service. Where
        you are not happy with the service GOFish provide, then please contact
        Customer Support. Where you are not happy with any initial resolution,
        GOFish operates a Complaints Policy (a copy of which is available upon
        request), which will aim to satisfy any complaints you have.
      </p>
      <p>
        12.2 If this does not resolve your complaint, you can upload your
        complaint via the European Commission's ODR platform. This platform for
        online dispute resolution can be found here: http://ec.europa.eu/odr.
      </p>
      <p>
        12.3 If your complaint is about your experience or service received
        whilst at the Fishery, you should direct your complaint to the Fishery
        directly. If you are not satisfied with their response or resolution,
        then please contact Customer Support and we will try to remedy the
        situation between you and the Fishery. However, please note, GOFish are
        not responsible for the actions or omissions of the Fishery and cannot
        control or mandate that the Fishery do anything, including providing you
        with a resolution or remedy to your complaint.
      </p>
      <p>
        12.4 These T&Cs and any Fishing Tickets and/or Hot Spots reserved
        through the Websites are governed by and construed in accordance with
        the laws of England & Wales.
      </p>

      <p><strong>13. ABOUT US</strong></p>
      <p>
        13.1 GOFish, is trading name of Galgorm Holdings Limited, 27-28 The
        Courtyard Galgorm Castle, BALLYMENA, Co. Antrim, BT42 1HL
      </p>
      <p>
        13.2 Our Customer Support team is based in the UK and can be contacted
        at:
      </p>
      <p>Post:</p>
      <p>Galgorm Holdings Limited</p>
      <p>27-28 The Courtyard Galgorm Castle</p>
      <p>BALLYMENA,</p>
      <p>BT42 1HL</p>
      <p>UK</p>

      <p>Phone: +44 28 2565 000</p>
      <p>GMT/BST 9.00am – 5.00pm (Monday to Friday, excluding 25 December)</p>

      <p>Email: support@GOFish.Global</p>
      <p>Thank you for booking with GOFish.</p>
    </div>
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
