import snakeCase from "lodash/snakeCase";
import isArray from "lodash/isArray";
import mapKeys from "lodash/mapKeys";
import mapValues from "lodash/mapValues";
import map from "lodash/map";
import isObject from "lodash/isObject";

export const convertObjectKeys = (object, func = snakeCase) => {
  if (!isObject(object)) {
    return object;
  }

  return mapValues(
    mapKeys(object, (value, key) => func(key)),
    (value) => {
      if (isObject(value)) {
        if (isArray(value)) {
          return map(value, (val) => convertObjectKeys(val, func));
        } else {
          return convertObjectKeys(value, func);
        }
      }
      return value;
    }
  );
};
