const isClient = typeof window !== "undefined";

if (isClient) {
    window._learnq = window._learnq || [];
}

export const userRegister = ({ firstName, lastName, role, email }) => {
    if (isClient) {
        window._learnq.push(['identify', {
            '$email': email,
            '$first_name': firstName,
            '$last_name': lastName,
            'role': role
        }]);
    }
}

export const trackViewedVenue = ({ name, id, image, url }) => {
    if (isClient) {
        window._learnq.push(['track', 'Viewed Venue', {
            id,
            name,
            image,
            url
        }]);
    }
}