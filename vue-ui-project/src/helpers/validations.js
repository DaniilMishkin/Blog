import { maxLength, minLength, required, helpers } from "@vuelidate/validators";

export const required$ = helpers.withMessage(
  "The field cannot be empty",
  required
);

export const minLength$ = (length) =>
  helpers.withMessage(
    ({ $params }) => `Should contain at least ${$params.min} digits.`,
    minLength(length)
  );

export const maxLength$ = (length) =>
  helpers.withMessage(
    ({ $params }) => `Should contain max ${$params.min} digits.`,
    maxLength(length)
  );

// export const validations = {
//     name: {
//         required: helpers.withMessage('This field cannot be empty', required),
//         maxLength: helpers.withMessage(({ $params }) => `Should contain max ${$params.min} digits.`, minLength(length)),
//     }
// }
