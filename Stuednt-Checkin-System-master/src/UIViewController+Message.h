//
//  UIViewController+Message.h
//  QRtest
//
//  Created by 邵闻远 on 20/04/2017.
//  Copyright © 2017 shaowy. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIViewController (Message)

- (void)showAlertWithTitle:(NSString *)title message:(NSString *)message handler:(void (^) (UIAlertAction *action))handler;

@end
