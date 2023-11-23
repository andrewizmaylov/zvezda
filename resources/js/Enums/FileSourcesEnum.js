export const FileSourcesEnum = Object.freeze({
	MessageAttachment: 1,
	Logo: 2,
	ContentImage: 3,
	ProfilePhoto: 4,
	Image: 5,
	Banner: 6,
});

export function getIdFromEnum(key) {
	return FileSourcesEnum[key.charAt(0).toUpperCase() + key.slice(1)];
}