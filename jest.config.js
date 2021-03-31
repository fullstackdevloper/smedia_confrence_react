module.exports = {
  roots: ['<rootDir>/resources/js'],
  transform: {
    '^.+\\.tsx?$': 'ts-jest',
  },
  testRegex: '(/__tests__/.*|(\\.|/)(test|spec))\\.tsx?$',
  moduleFileExtensions: ['ts', 'tsx', 'js', 'jsx', 'json', 'node'],
  snapshotSerializers: ['enzyme-to-json/serializer'],
  setupFiles: ['<rootDir>/resources/js/setupTests.ts'],
  reporters: ['default', 'jest-junit'],

  // We don't need to test the static JSX in the icons folder, so let's exclude it from our test coverage report
  coveragePathIgnorePatterns: ['node_modules', 'resources/js/icons'],
};
